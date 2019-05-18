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
 * create dependent objects before running each test
 */
	public final function setUp() : void {
		//run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILE_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 */
	public function testInsertValidProfile() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME
		, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_HASH);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 */
	public function testUpdateValidateProfile() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert to into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME
			, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_HASH);
		$profile->insert($this->getPDO());

		//edit the Profile and update it in mySQL
		$profile->setProfileFirstName($this->VALID_PROFILE_FIRST_NAME);
		$profile->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
	}

}