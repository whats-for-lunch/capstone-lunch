<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use WhatsForLunch\CapstoneLunch\Restaurant;

/**
 * api for the restaurant class
 *
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

try {
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort24/whatsforlunch");
	$pdo = $secrets->getPdoObject();

	// $_SESSION["profile"] = Profile::getProfileByProfileId($pdo, "b3200b81-2cdd-47dc-9e8e-21f9bd69fe3b");

//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantId = filter_input(INPUT_GET, "restaurantId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantAddress = filter_input(INPUT_GET, "restaurantDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantName = filter_input(INPUT_GET, "restaurantName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantLat = filter_input(INPUT_GET, "restaurantLat", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantLng = filter_input(INPUT_GET, "restaurantLng", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantPrice = filter_input(INPUT_GET, "restaurantPrice", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantReviewRating = filter_input(INPUT_GET, "restaurantReviewRating", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantThumbnail = filter_input(INPUT_GET, "restaurantThumbnail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$active = filter_input(INPUT_GET, "active", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("restaurant id cannot be empty or negative", 405));
	}

	// GET request
	if($method === "GET") {
		if($method === "GET") {
			//set XSRF cookie
			setXsrfCookie();

	//get a specific Restaurant based on arguments provided or all the restaurants and update reply
	if(empty($id) === false) {
		$reply->data = Restaurant::getRestaurantByRestaurantId($pdo, $id);
	} else {
		$reply->data = Restaurant::getAllRestaurants($pdo)->toArray();
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

		//make sure restaurant name is available (required field)
		if(empty($requestObject->restaurantName) === true) {
			throw(new \InvalidArgumentException ("No name for restaurant.", 405));
		}

		if($method === "PUT") {
		//determine if we have a PUT request. Process PUT request here

		// retrieve the restaurant to update
		$restaurant = Restaurant::getRestaurantByRestaurantId($pdo, $id);
		if($restaurant === null) {
			throw(new RuntimeException("Restaurant does not exist", 404));
	}
/**
		//enforce the user is signed in and only trying to edit their own favorites list
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $restaurant->getProfileId()->toString()) {
			throw(new \InvalidArgumentException("Sign in to add to your favorites", 403));
		}
 * ASK IF THIS IS EVEN NEEDED
 */

// update all attributes
		$restaurant->setRestaurantAddress($requestObject->restaurantAddress);
		$restaurant->setRestaurantLat($requestObject->restaurantLat);
		$restaurant->setRestaurantLng($requestObject->restaurantLng);
		$restaurant->setRestaurantName($requestObject->restaurantName);
		$restaurant->setRestaurantPrice($requestObject->restaurantPrice);
		$restaurant->setRestaurantReviewRating($requestObject->restaurantReviewRating);
		$restaurant->setRestaurantThumbnail($requestObject->restaurantThumbnail);
		$restaurant->update($pdo);

			// update reply
			$reply->message = "Everything updated";

		} else if($method === "POST") {
			//process POST request here
			// enforce the user is signed in

			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to add to favorite list", 403));
			}

		}
	}