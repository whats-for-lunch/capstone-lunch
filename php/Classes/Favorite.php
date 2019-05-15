<?php

namespace whatsforlunch\capstoneLunch;

require_once ("autoload.php");
require_once (dirname(__DIR__) .  "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;

/**
 * Favorite class for the users of the whatsForLunch application
 * This Favorite class describes the attributes that make up the user's favorite list.
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */

class Favorite implements \JsonSerializable
{
	use ValidateUuid;

	/**
	 * foreign key for the profile id
	 * @var
	 */
	private $favoriteProfileId;
	/**
	 * foreign key for the restaurant id
	 * @var
	 */
	private $favoriteRestaurantId;

	/**
	 * Constructor for Favorites
	 *
	 * @param Uuid| string $newFavoriteProfileId value for the favorite profile id
	 * @param Uuid| string $newFavoriteRestaurantId value for the favorite restaurant id
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the data values entered are too large
	 * @throws \TypeError if the data type violate hints
	 * @throws \Exception
	 */
	public function __construct(string $newFavoriteProfileId, string $newFavoriteRestaurantId) {
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteRestaurantId($newFavoriteRestaurantId);
		} //Determine the exception that was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
}

/**
 * accessor method for the favoriteProfileId
 * @return Uuid value of the favorite profile id
 */
	public function getFavoriteProfileId() : Uuid {
		return($this->favoriteProfileId);
	}

	/**
	 * Mutator method for the favoriteProfileId
	 *
	 * @param Uuid| string $newFavoriteProfileId new value of favorite profile id
	 * @throws \RangeException if the $newFavoriteProfileId is not positive
	 * @throws \TypeError if $newFavoriteProfileId is not a Uuid or string
	 */
	public function setFavoriteProfileId($newFavoriteProfileId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the new favorite profile id
		$this->favoriteProfileId = $uuid;
	}

	/**
	 * accessor method for the favoriteRestaurantId
	 * @return Uuid value of the favorite Restaurant id
	 */
	public function getFavoriteRestaurantId() : Uuid {
		return($this->favoriteRestaurantId);
	}

	/**
	 * Mutator method for the favoriteRestaurantId
	 *
	 * @param Uuid| string $newFavoriteRestaurantId new value of favorite restaurant id
	 * @throws \RangeException if the $newFavoriteRestaurantId is not positive
	 * @throws \TypeError if $newRestaurantId is not a uuid or a string
	 */
	public function setFavoriteRestaurantId($newFavoriteRestaurantId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteRestaurantId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the favoriteRestaurantId
		$this->favoriteRestaurantId = $uuid;
	}

	/**
	 * Insert statement for favorite class
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		// create a query template
		$query = "insert into favorite(favoriteProfileId, favoriteRestaurantId) values (:favoriteProfileId, favoriteRestaurantId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["favoriteRestaurantId" => $this->favoriteRestaurantId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * Delete statement for the favorite class
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) : void {
		//create a query template
		$query = "delete from favorite where favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $this->favoriteRestaurantId->getBytes()];
		$statement->execute($parameters);
	}

	
	//TODO getFavoriteByProfileId
	//TODO getFavoriteByRestaurantId
	//TODO getFavoriteByProfileRestaurantId

	/**
	 * get favorite by profile id statement
	 *
	 * @param \PDO $pdo connection object
	 * @param Uuid|string $profileId profile id to search for
	 * @return Favorite|null profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 */
	public static function getFavoriteByProfileId(\PDO $pdo, $profileId) : \SplFixedArray {
		//sanitize the profileId before searching
		try{
			$profileId = self::validateUuid($profileId);
		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create a query template
		$query = "select favoriteProfileId, favoriteRestaurantId from profile where profileId = :profileId";
		$statement = $pdo->prepare($query);

		//bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);

		//grab the favoriteProfile id from mySQL
		try{
			$profile =
		}
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