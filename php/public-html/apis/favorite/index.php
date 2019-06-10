<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use WhatsForLunch\CapstoneLunch\{
	Favorite
};
/**
 * Api for the favorite class
 *
 * @author Jeffrey Gallegos
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/whatsforlunch.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize the search parameters
	$favoriteProfileId = $id = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$favoriteRestaurantId = $id = filter_input(INPUT_GET, "favoriteRestaurantId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a specific favorite associated based on its composite key
		if ($favoriteProfileId !== null && $favoriteRestaurantId !== null) {
			$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteRestaurantId($pdo, $favoriteProfileId, $favoriteRestaurantId);
			if($favorite !== null) {
				$reply->data = $favorite;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($favoriteProfileId) === false) {
			$reply->data = Favorite::getFavoriteByFavoriteProfileId($pdo, $favoriteProfileId)->toArray();
			//get all the favorites associated with the restaurantId
		} else if(empty($favoriteRestaurantId) === false) {
			$reply->data = Favorite::getFavoriteByFavoriteRestaurantId($pdo, $favoriteRestaurantId)->toArray();
		} else {
			throw new InvalidArgumentException("incorrect search parameters", 404);
		}
	} else if($method === "POST" || $method === "PUT") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->favoriteProfileId) === true) {
			throw (new \InvalidArgumentException("No Profile linked to the Favorite", 405));
		}
		if(empty($requestObject->favoriteRestaurantId) === true) {
			throw (new \InvalidArgumentException("No Restaurant linked to the Favorite", 405));
		}
		if(empty($requestObject->FavoriteDate) === true) {
			$requestObject->FavoriteDate =  date("y-m-d H:i:s");
		}
		if($method === "POST") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();
			//enforce the end user has a JWT token
			//validateJwtHeader();
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to access favorites", 403));
			}
			validateJwtHeader();
			$favorite = new Favorite($_SESSION["profile"]->getProfileId(), $requestObject->favoriteRestaurantId);
			$favorite->insert($pdo);
			$reply->message = "restaurant successfully added to favorites";
		} else if($method === "PUT") {
			//enforce the end user has a XSRF token.
			verifyXsrf();
			//enforce the end user has a JWT token
			validateJwtHeader();
			//grab the favorite by its composite key
			$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteRestaurantId($pdo, $requestObject->favoriteProfileId, $requestObject->favoriteRestaruantId);
			if($favorite === null) {
				throw (new RuntimeException("favorite does not exist"));
			}
			//enforce the user is signed in and only trying to edit their own favorite
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $favorite->getFavoriteProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this favorite", 403));
			}
			//validateJwtHeader();
			//preform the actual delete
			$favorite->delete($pdo);
			//update the message
			$reply->message = "favorite successfully deleted";
		}
		// if any other HTTP request is sent throw an exception
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}
	//catch any exceptions that is thrown and update the reply status and message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);