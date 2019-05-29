<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use WhatsForLunch\CapstoneLunch\Restaurant;

/**
 * api for the restaurant class
 * @author Jamie Amparan <jamparan3@cnm.edu>
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

//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize input and store
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantId = filter_input(INPUT_GET, "restaurantId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantAddress = filter_input(INPUT_GET, "restaurantDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantName = filter_input(INPUT_GET, "restaurantName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantLat = filter_input(INPUT_GET, "restaurantLat", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantLng = filter_input(INPUT_GET, "restaurantLng", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantPrice = filter_input(INPUT_GET, "restaurantPrice", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantReviewRating = filter_input(INPUT_GET, "restaurantReviewRating", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_NO_ENCODE_QUOTES);
	$restaurantThumbnail = filter_input(INPUT_GET, "restaurantThumbnail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$active = filter_input(INPUT_GET, "active", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific Restaurant based on arguments provided or all the restaurants and update reply
		if(empty($id) === false) {
			$restaurant = Restaurant::getRestaurantByRestaurantId($pdo, $id);
			if($restaurant !== null) {
				$reply->data = $restaurant;
			}

		} else {
			$restaurants = Restaurant::getAllRestaurants($pdo)->toArray();
			if($restaurants !== null) {
				$reply->data = $restaurants;
			}
		}
		// If the method request is not GET an exception is thrown
	} else {
		throw (new InvalidArgumentException("Invalid HTTP Method Request", 418));
	}
	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
// In these lines, the Exceptions are caught and the $reply object is updated with the data from the caught exception. Note that $reply->status will be updated with the correct error code in the case of an Exception.
header("Content-type: application/json");
// sets up the response header.
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);