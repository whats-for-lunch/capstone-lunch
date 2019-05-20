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

class ProfileTest extends WhatsForLunchTest {

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
	public final function setUp(): void {
		//run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_PROFILE_ACTIVATION_TOKEN = bin2hex(random_bytes(16));
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 */
	public function testInsertValidProfile(): void {
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
	public function testUpdateValidateProfile(): void {
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
	 * test creating a Profile and then deleting it
	 */
	public function testDeleteValidProfile() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME
			, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_HASH);
		$profile->insert($this->getPDO());

		//delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		//test that this profile was deleted by grabbing profile id
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test grabbing a profile that doesn't exist
	 */
	public function testGetInvalidProfileByProfileId() : void {
		//grab profile id that exceeds the maximum allowable profile id
		$profileId = generateUuidV4();
		$profile = Profile::getProfileByProfileId($this->getPDO(), $profileId);
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a Profile by profile last name
	 */
	public function testGetValidProfileByProfileLastName() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert it into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME
			, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_HASH);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileLastName($this->getPDO(), $profile->getProfileLastName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);

		//enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("whatsForLunch\\capstoneLunch\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
	}

	/**
	 * test grabbing the Profile by profile email
	 */
	public function testGetValidProfileByProfileEmail() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert it into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME
			, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_HASH);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileEmail($this->getPDO(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));

		//enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("whatsForLunch\\capstoneLunch\\Profile", $results);

		//grab the result from the array and validate it
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
	}

	/**
	 * test grabbing the Profile by the profile activation token
	 * this will be used by the user to find and activate their profile from an email
	 */
	public function testGetValidProfileByProfileActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create a new Profile and insert it into mySQL
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_PROFILE_ACTIVATION_TOKEN, $this->VALID_PROFILE_EMAIL, $this->VALID_PROFILE_FIRST_NAME
			, $this->VALID_PROFILE_LAST_NAME, $this->VALID_PROFILE_HASH);
		$profile->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());

		//grab the result from the array and validate it
		$pdoProfile = $results;
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profileId);
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_PROFILE_ACTIVATION_TOKEN);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILE_EMAIL);
		$this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_PROFILE_FIRST_NAME);
		$this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_PROFILE_LAST_NAME);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILE_HASH);
	}


}