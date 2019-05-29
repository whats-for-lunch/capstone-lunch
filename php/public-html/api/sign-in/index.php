<?php
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use WhatsForLunch\CapstoneLunch\Profile;

/**
 *  API for app sign in, Profile class
 * POST requests are supported.
 *@author Jamie Amparan <jamparan3@cnm.edu>
 **/

//Verify the session. If it's not active, start it.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	// Grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/whatsforlunch.ini");
	$pdo = $secrets->getPdoObject();
	// Determine which HTTP method was used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize inputs
	//$profiled = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_EMAIL);
	//$profileHash = filter_input(INPUT_GET, "profileHash", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//make sure the profileId is valid for methods that require it
	//if(($method === "DELETE" || $method === "PUT") && (empty($profileId) === true)) {
	//throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	//}
	//}
	// If the method is POST, handle the sign -in logic.
	if($method === "POST") {
		// Make sure the XSRF Token is valid.
		verifyXsrf();
		// Process the request content and decode the json object into a PHP object.
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		// Check for the email (required field)
		if(empty($requestObject->profileEmail) === true) {
			throw (new \InvalidArgumentException("An email address must be entered.", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);
		}
		// Check for the password (required field).
		if(empty($requestObject->profileHash) === true) {
			throw (new \InvalidArgumentException("A password must be entered.", 401));
		} else {
			$profileHash = $requestObject->profileHash;
		}
		// Grab the profile from the database by the email address provided.
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Invalid Email", 401));
		}
		$profile->setProfileActivationToken(null);
		$profile->update($pdo);
		// If the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null) {
			throw (new \InvalidArgumentException("Log In To Save Your Favorites!", 403));
		}
		// Verify hash is correct
		if(password_verify($requestObject->profileHash, $profile->getProfileHash()) === false) {
			throw(new \InvalidArgumentException("invalid password.", 401));
		}
		// Grab the profile from the database and put it into a session.
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());
		$_SESSION["profile"] = $profile;
		// Create the authorization payload
		$authObject = (object)[
			"profileId" => $profile->getProfileId(),
			"profileActivationToken" => $profile->getProfileActivationToken()
		];
		// Create and set the JWT
		setJwtAndAuthHeader("auth", $authObject);
		$reply->message = $authObject->profileId;
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!"));
	}
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
// Sets up the response header.
header("Content-type: application/json");
// JSON encode the $reply object and echo it back to the front end
echo json_encode($reply);