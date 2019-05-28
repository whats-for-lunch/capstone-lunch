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
}