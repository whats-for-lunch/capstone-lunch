<?php
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/lib/jwt.php");
require_once (dirname(__DIR__, 3) . "/lib/uuid.php");
require_once ("/etc/apache2/capstone-mysql/Secrets.php");


use WhatsForLunch\CapstoneLunch\Picture;


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
//prepare an empty reply
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
        $id = filter_input(INPUT_GET, "profileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $profileFirstName = filter_input(INPUT_GET, "profileFirstName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $profileLastName = filter_input(INPUT_GET, "profileLastName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $restaurantId = filter_input(INPUT_GET, "restaurantId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $restaurantThumbnail = filter_input(INPUT_GET, "restaurantThumbnail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $favoriteProfileId = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //have to make sure that id is valid for all methods that require it
        if (($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
            throw(new \InvalidArgumentException("id cannot be empty of negative", 405));
        }

        if ($method == "GET") {
            // set XSRF-TOKEN to prev
            setXsrfCookie();

            //get a specific Picture based on arguments provided or all the pictures and updated reply
            if (empty($id) === false) {
                $picture = Picture::getPictureByPictureId($pdo, $id);
                if ($picture !== null) {
                    $reply->data = $picture;
                }
            } else {
                $picture = Picture::getPictureByPictureRestaurantId($pdo)->toArray();
                if ($picture !== null) {
                    $reply->data = $picture;
                }
            }
        } else {
            throw (new InvalidArgumentException("Invalid HTTP Method Request", 418));
        }

        //update reply with exception information
    } catch(Exception $exception) {
        $reply->status = $exception->getCode();
        $reply->message = $exception->getMessage();
        $reply->trace = $exception->getTraceAsString();
    } catch(TypeError $typeError) {
        $reply->status = $typeError->getCode();
        $reply->message = $typeError->getMessage();
    }

    //In these lines, the Exception are caught and the $reply object is updated with teh data from teh caought excpetion . Note that $reply->status will be updated with the correct error code in the case of an Exception.
    header("Content-type: application/json");

    // sets up the response header.
    if ($reply->data === null) {
        unset($reply->data);
    }
    echo json_encode($reply);
}
