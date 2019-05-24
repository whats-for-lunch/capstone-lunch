<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/Classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once ("/etc/apache2/capstone-mysql/Secrets.hp");

use WhatsForLunch\CapstoneLunch\{
  //not testing any class not putting anything specific
};

/**
 * api for the sign up
 *
 * @author {} thebestjesse76@gmail.com
 *
 **/

//verify the session, start if not the new session
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
