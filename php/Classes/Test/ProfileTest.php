<?php

namespace whatsforlunch\capstoneLunch;

use whatsforlunch\capstoneLunch\Profile;
require_once("");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");


/**
 * Full PHPUnit test for the Profile Class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods are
 * tested for both invalid and valid inputs
 *
 * @see \whatsforlunch\capstoneLunch\Profile
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */

class ProfileTest extends  {

	/**
	 * content of the profile activation token
	 * @var string $profileActivationToken
	 */
	protected $VALID_PROFILE_ACTIVATION_TOKEN = null;

	/**
	 * content of the profile email
	 * @var string $profileEmail
	 */
	protected $VALID_PROFILE_EMAIL = "PHPUnit test passing";
	/**
	 * content of the profile first name; this starts as null and is assigned later
	 * @var string $profileFirstName
	 **/
	protected $VALID_PROFILE_FIRST_NAME = "PHPUnit";

	/**
	 * content of the profile last name; this starts as null and is assigned later
	 * @var string $profileLastName
	 **/
	protected $VALID_PROFILE_LAST_NAME = "test still";

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var string $profileHash
	 */
	protected $VALID_PROFILE_HASH;

/**
 * create 
 */

}