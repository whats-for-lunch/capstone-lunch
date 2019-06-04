<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/Classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");


use WhatsForLunch\CapstoneLunch\ {
    Picture
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
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
    //grab the MySql connection
    $secrets = new \Secrets("/etc/apache2/capstone-mysql/whatsforlunch.ini");
    $pdo = $secrets->getPdoObject();
    //waiting on yelp data not sure if this would be how to use
    // $yelp = $secrets->getSecret("yelp");

    //determine which HTTP method was used
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
    if ($method === "GET") {
//        // set XSRF cookie
//        setXsrfCookie();

//Sanitizing all inputs
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $restaurantId = filter_input(INPUT_GET, "restaurantId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $restaurantThumbnail = filter_input(INPUT_GET, "restaurantThumbnail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $favoriteProfileId = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


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
    } catch (\Exception | \TypeError $exception) {
        $reply->status = $exception->getCode();
        $reply->message = $exception->getMessage();
        $reply->trace = $exception->getTraceAsString();
    }

    // sets up the response header.
    if ($reply->data === null) {
        unset($reply->data);
    }
    header("Content-type: application/json");
    echo json_encode($reply);

