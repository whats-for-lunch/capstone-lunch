<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use WhatsForLunch\CapstoneLunch\Profile;

/**
 * api for the profile class
 *
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/whatsforlunch.ini");
	$pdo = $secrets->getPdoObject();

	// $_SESSION["profile"] = Profile::getProfileByProfileId($pdo, "b3200b81-2cdd-47dc-9e8e-21f9bd69fe3b");

//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileFirstName = filter_input(INPUT_GET, "profileFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileLastName = filter_input(INPUT_GET, "profileLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileHash = filter_input(INPUT_GET, "profileHash", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$active = filter_input(INPUT_GET, "active", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("profile id cannot be empty or negative", 405));
	}

	// GET request
	if($method === "GET") {
		if($method === "GET") {
			//set XSRF cookie
			setXsrfCookie();

			//get a specific Profile based on arguments provided
			if(empty($id) === false) {
				$reply->data = Profile::getProfileByProfileId($pdo, $id);
			}
			else if(empty($profileEmail) === false) {
				$reply->data = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			}
			else if(empty($profileActivationToken) === false) {
				$reply->data = Profile::getProfileByProfileActivationToken($pdo, $profileActivationToken);
			}
		}

//if it's not a GET request, we determine if we have a PUT or POST request
	} else if($method === "PUT" || $method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");

		// This Line Then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);


		//make sure profile email is available (required field)
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("No email for profile.", 405));
		}

		if($method === "PUT") {
			//determine if we have a PUT request. Process PUT request here

			// retrieve the profile to update
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile == null) {
				throw(new RuntimeException("Profile does not exist", 404));
			}
			/**
			 * ASK IF THIS IS EVEN NEEDED
			//enforce the user is signed in and only trying to edit their own favorites list
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $restaurant->getProfileId()->toString()) {
			throw(new \InvalidArgumentException("Sign in to add to your favorites", 403));
			}

			 */

// update all attributes
			$profile->setProfileId($requestObject->profileId);
			$profile->setProfileActivationToken($requestObject->profileActivationToken);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileFirstName($requestObject->profileFirstName);
			$profile->setProfileLastName($requestObject->profileLastName);
			$profile->setProfileHash($requestObject->profileHash);
			$profile->update($pdo);

			// update reply
			$reply->message = "Everything updated";

		} else if($method === "POST") {
			//process POST request here
			// enforce the user is signed in

			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to add to favorite list", 403));
			}

			// create new profile and insert into the database
			$profile = new Profile(generateUuidV4(), $_SESSION["profile"]->$requestObject->profileId,
				$requestObject->profileActivationToken, $requestObject->profileEmail, $requestObject->profileFirstName,
				$requestObject->profileLastName, $requestObject->profileHash);
			$profile->insert($pdo);

			// update reply
			$reply->message = "New Profile";
		}

		//if above requests are neither PUT nor POST, use DELETE below
	} else if($method === "DELETE") {
		//process DELETE request
		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the profile to be deleted
		$profile = Profile::getProfileByProfileId($pdo, $id);
		if($profile === null) {
			throw(new RuntimeException("Profile Does Not Exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own favorites page
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $profile->getProfileId()) {
			throw(new \InvalidArgumentException("Sign In to Delete From Your Favorites", 403));
		}

		// delete profile
		$profile->delete($pdo);

		// update reply
		$reply->message = "Profile deleted";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 400));
	}

	// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);