<?php
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/lib/jwt.php");
require_once (dirname(__DIR__, 3) . "/lib/uuid.php");
require_once ("/etc/apache2/captstone-mysql/Secrets.php");


use WhatsForLunch\CapstoneLunch\ {Picture
};

/**
 * api for the picture
 *
 * @author Jesus Silva thebestjesse76@gmail.com
 *
 */

//Check the session. If it is not active, start the session.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
//prepare an empty replly
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try{
    //grab the MySql connection
    $secrets =new \Secrets("/etc/apache2/capstone-mysql/WhatsForLunch.ini");
    $pdo = $secrets->getPDOObject();

    //determine which HTTP method was used
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
    if ($method === "GET") {
        // set XSRF cookie
        setXsrfCookie();

//Sanitizing all inputs
    $id = filter_input(INPUT_GET,"profileId" , FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $profileFirstName = filter_input(INPUT_GET, "profileFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $profileLastName = filter_input(INPUT_GET, "profileLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $restaurantId = filter_input(INPUT_GET, "restaurantId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $restaurantThumbnail = filter_input(INPUT_GET, "restaurantThumbnail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $favoriteProfileId = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    //have to make sure that id is valid for all methods that require it
        if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
            throw(new \InvalidArgumentException("id cannot be empty of negative", 405));
        }

        if($method =="GET") {
            // set XSRF-TOKEN to prev
        }

    }
}
