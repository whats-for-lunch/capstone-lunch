<?php

namespace jgallegos\capstonelunch;

require_once (dirname(__DIR__) .  "/classes/autoload.php");

use http\Exception\InvalidArgumentException;
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


	/**
	 * Constructor for this profile
	 *
	 * @param Uuid| string $newProfileId value for new profileId
	 * @param string $newProfileActivationToken
	 * @param string $newProfileEmail
	 * @param string $newProfileFirstName
	 * @param string $newProfileLastName
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values entered are too long
	 * @throws \TypeError if data types violate hints
	 * @throws \Exception
	 */

	public function __construct(string $newProfileId, string $newProfileActivationToken, string $newProfileEmail,
	string $newProfileFirstName, string $newProfileLastName, string $newProfileHash) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileLastName);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileHash($newProfileHash);
		} //Determine the exception that was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for the profile id
	 * @return Uuid value of the profile id
	 */
	public function getProfileId(): Uuid {
		return ($this->profileId);
	}

	/**
	 * mutator method for profileId
	 *
	 * @param Uuid| string $newProfileId value for new profile id
	 * @throws \RangeException if the $newProfileId is not positive
	 * @throws \TypeError if the profileId is not valid
	 */
	public function setProfileId($newProfileId): void {
		try{
			$Uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the profileId
		$this->profileId = $Uuid;
	}

	/**
	 * accessor method for profile activation token
	 * @return string value of the activation token
	 */
	public function getProfileActivationToken() : string {
		return ($this->profileActivationToken);
	}

	/**
	 * mutator method for profile activation token
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or is insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setProfileActivationToken(string $newProfileActivationToken) : void {
		if ($newProfileActivationToken === null) {
			$this->profileActivationToken = null;
			return;
		}
		$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
		if(ctype_xdigit($newProfileActivationToken) === false) {
			throw (new\RangeException("profile activation token is not valid"));
		}
		//to determine if the activation token has 32 characters
		if(strlen($newProfileActivationToken) !== 32) {
			throw (new\RangeException("profile activation token has to be 32 characters"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}

	/**
	 * accessor method for profile email
	 * @return string value for profile email
	 */
	public function getProfileEmail() : string {
		return ($this->profileEmail);
	}

	/**
	 * mutator method for the profile email
	 *
	 * @param string $newProfileEmail of new value of email
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or is insecure
	 * @throws \RangeException if the $newProfileEmail is more than 128 characters
	 * @throws \TypeError if the new email is not a string
	 */
	public function setProfileEmail(string $newProfileEmail) : void {
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw (new \InvalidArgumentException("profile email is empty or insecure"));
		}
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}
		$this->profileEmail = $newProfileEmail;
	}
	
}