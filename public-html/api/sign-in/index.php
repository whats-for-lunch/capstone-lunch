<?php
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use DeepDiveDatingApp\DeepDiveDating\User;
/**
 *  API for app sign in, User class
 *
 * POST requests are supported.
 *
 * @author Nehomah Mora <nmora9@cnm.edu>
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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/dateadan.ini");
	$pdo = $secrets->getPdoObject();
	// Determine which HTTP method was used.
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize inputs
	//$userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_EMAIL);
	//$userHash = filter_input(INPUT_GET, "userHash", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//make sure the userId is valid for methods that require it
	//if(($method === "DELETE" || $method === "PUT") && (empty($userId) === true)) {
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
		if(empty($requestObject->userEmail) === true) {
			throw (new \InvalidArgumentException("An email address must be entered.", 401));
		} else {
			$userEmail = filter_var($requestObject->userEmail, FILTER_SANITIZE_EMAIL);
		}
		// Check for the password (required field).
		if(empty($requestObject->userPassword) === true) {
			throw (new \InvalidArgumentException("A password must be entered.", 401));
		} else {
			$userPassword = $requestObject->userPassword;
		}
		// Grab the user from the database by the email address provided.
		$user = User::getUserByEmail($pdo, $userEmail);
		if(empty($user) === true) {
			throw(new \InvalidArgumentException("Invalid Email", 401));
		}
		$user->setUserActivationToken(null);
		$user->update($pdo);
		// If the profile activation is not null throw an error
		if($user->getUserActivationToken() !== null) {
			throw (new \InvalidArgumentException("You are not allowed to sign in unless you have activated your account", 403));
		}
		// Verify hash is correct
		if(password_verify($requestObject->userPassword, $user->getUserHash()) === false) {
			throw(new \InvalidArgumentException("Invalid password.", 401));
		}
		// Grab the user from the database and put it into a session.
		$user = User::getUserByUserId($pdo, $user->getUserId());
		$_SESSION["user"] = $user;
		// Create the authorization payload
		$authObject = (object)[
			"userId" => $user->getUserId(),
			"userHandle" => $user->getUserHandle()
		];
		// Create and set the JWT
		setJwtAndAuthHeader("auth", $authObject);
		$reply->message = $authObject->userId;
	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!"));
	}
}catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->mesage = $exception->getMessage();
}
// Sets up the response header.
header("Content-type: application/json");
// JSON encode the $reply object and echo it back to the front end
echo json_encode($reply);