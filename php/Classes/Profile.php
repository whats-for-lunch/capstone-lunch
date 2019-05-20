<?php
namespace WhatsForLunch\CapstoneLunch;

require_once ("autoload.php");
require_once (dirname(__DIR__) .  "/classes/autoload.php");

use http\Exception\InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 *Profile class for the users of the WhatsForLunch application
 * This profile class describes the attributes that make up the user profile.
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */

class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this profile; this is the primary key
	 * @var uuid profileId
	 */
	private $profileId;
	/**
	 * activation token for this profile;
	 * token handed out to verify that the profile is valid and not malicious.
	 * @var uuid $profileActivationToken
	 */
	private $profileActivationToken;
	/**
	 * email for the profile; this is a unique index
	 * email used for verification of profile on sign in.
	 * @var string profileEmail
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
	 * the hash for the profile's password;
	 * @var string $profileHash
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
			$this->setProfileActivationToken($newProfileActivationToken);
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
		try {
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
	public function getProfileActivationToken(): string {
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
	public function setProfileActivationToken(string $newProfileActivationToken): void {
		if($newProfileActivationToken === null) {
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
	public function getProfileEmail(): string {
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
	public function setProfileEmail(string $newProfileEmail): void {
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

	/**
	 * accessor method for profileFirstName
	 * @return string value for profile first name
	 */
	public function getProfileFirstName(): string {
		return ($this->profileFirstName);
	}

	/**
	 * mutator method for the first name of the profile user
	 *
	 * @param string $newProfileFirstName
	 * @throws \InvalidArgumentException if the first name is not a string or is insecure
	 * @throws \RangeException if the first name is more than 128 characters
	 * @throws \TypeError if the first name is not a string
	 */
	public function setProfileFirstName(string $newProfileFirstName): void {
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("profile first name is empty or insecure"));
		}
		if(strlen($newProfileFirstName) > 128) {
			throw(new \RangeException("profile first name is too large"));
		}
		$this->profileFirstName = $newProfileFirstName;
	}

	/**
	 * accessor method for profileLastName
	 * @return string value for profile last name
	 */
	public function getProfileLastName(): string {
		return ($this->profileLastName);
	}

	/**
	 * mutator method for the last name of the profile user
	 *
	 * @param string $newProfileLastName
	 * @throws \InvalidArgumentException if the last name is not a string or is insecure
	 * @throws \RangeException if the last name is more than 128 characters
	 * @throws \TypeError if the last name is not a string
	 */
	public function setProfileLastName(string $newProfileLastName): void {
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("profile last name is empty or insecure"));
		}
		if(strlen($newProfileLastName) > 128){
			throw(new \RangeException("profile last name is too large"));
		}
		$this->profileLastName = $newProfileLastName;
	}

	/**
	 * accessor method for profile hash
	 * @return string value of the hash
	 */
	public function getProfileHash() : string {
		return ($this->profileHash);
	}

	/**
	 * mutator method for the profile hash
	 * @param string $newProfileHash new value of hash
	 * @throws \InvalidArgumentException if the new profile hash is not a string or is insecure
	 * @throws \RangeException if the new profile hash is too large
	 * @throws \TypeError if the new profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash) : void {
		$newProfileHash = trim($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile hash is empty or is insecure"));
		}
		$profileHashInfo = password_get_info($newProfileHash);
		if($profileHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("profile hash is not a valid hash"));
		}
		if(strlen($newProfileHash) > 97) {
			throw(new \RangeException("profile hash is too large"));
		}
		$this->profileHash = $newProfileHash;
	}

	/**
	 * Insert statement for the profile class
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		//create a query template
		$query = "insert into profile(profileId, profileActivationToken, profileEmail, profileFirstName, profileLastName, profileHash)
					values(:profileId, :profileActivationToken, :profileEmail, :profileFirstName, :profileLastName, :profileHash)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken->getBytes(), "profileEmail" => $this->profileEmail->getBytes(),
			"profileFirstName" => $this->profileFirstName->getBytes(), "profileLastName" => $this->profileLastName->getBytes(), "profileHash" => $this->profileHash->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Delete statement for the profile class
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection type
	 */
	public function delete(\PDO $pdo) : void {
		//create a query template
		$query = "delete from profile where profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Update statement for the profile class
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection type
	 */
	public function update(\PDO $pdo) : void {
		//create a query template
		$query = "update profile set profileEmail = :profileEmail, profileFirstName = :profileFirstName, profileLastName = :profileLastName, profileHash = :profileHash";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * get profile by profile id statement
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| string $profileId profile id to search for
	 * @return Profile|null profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 */
	public function getProfileByProfileId (\PDO $pdo, $profileId) : ?Profile {
		//sanitize the profileId before searching
		try {
			$profileId = self :: validateUuid ($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create a query template
		$query = "select profileId, profileActivationToken, profileEmail, profileFirstName, profileLastName, profileHash 
		from profile where profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind the profile id to the template place holder
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		//get profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileFirstName"],
					$row["profileLastName"], $row["profileHash"]);
			}
		} catch(\Exception $exception) {
			//if the row could not be converted rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 *get profile by profile email statement
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param  String $profileEmail to search by
	 * @return  profile found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileEmail(\PDO $pdo, $profileEmail) : Profile {
		//create a query template
		$query = "select profileId, profileActivationToken, profileEmail, profileFirstName, profileLastName, profileHash
		from profile where profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		//bind the profile email to the place holder in the template
		$parameters = ["profileEmail" => $profileEmail];
		$statement->execute($parameters);
		// grab the profile from mySQL
		try {
			$profileEmail = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profileEmail = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileFirstName"],
					$row["profileLastName"], $row["profileHash"]);
			}
		}catch(\Exception $exception) {
			//if the row could not be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profileEmail);
	}

	/**
	 * get profile by profile activation token statement
	 *
	 * @param \PDO $pdo connection object
	 * @param string $profileActivationToken to search for
	 * @return profile found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables aren't the correct data type
	 */
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : Profile {
		//create a query template
		$query = "select profileId, profileActivationToken, profileEmail, profileFirstName, profileLastName, profileHash from
 		profile where profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		//bind the profile activation token to the place holder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		//grab the profile from mySQL
		try {
			$profileActivationToken = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profileActivationToken = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"],
					$row["profileFirstName"], $row["profileLastName"], $row["profileHash"]);
			}
		} catch(\Exception $exception) {
			//if the row could not be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profileActivationToken);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		return ($fields);
	}

}