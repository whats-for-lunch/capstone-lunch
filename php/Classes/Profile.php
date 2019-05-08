<?php

namespace jgallegos\capstonelunch;

require_once (dirname(__DIR__) .  "/classes/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *Profile class for the users of the whatsforlunch application
 * This profile class describes the attributes that make up the user profile.
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */

class profile {
	use validateUuid;
	/**
	 * id for this profile; this is the primary key
	 * @var uuid profileId
	 */
	private $profileId;
	/**
	 * activation token for this profile;
	 * token handed out to verify that the profile is valid and not malicious.
	 *@var $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * email for the profile; this is a unique index
	 * email used for verification of profile on sign in.
	 * @@var string profileEmail
	 */
	private $profileEmail;
	/**
	 * first name of the profile user;
	 * @var string profileFirstName
	 */
	private $profileFirstName;
	/**
	 * last name of the profile user;
	 * @var string profileLastName
	 */
	private $profileLastName;
	/**
	 *the hash for the profile's password;
	 * @var $profileHash
	 */
	private $profileHash;
}