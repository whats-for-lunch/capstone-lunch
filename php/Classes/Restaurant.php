<?php

namespace WhatsForLunch\CapstoneLunch;

require_once ("autoload.php");
require_once (dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * create a class for restaurant in project 'What's for lunch?'
 *
 */
class Restaurant implements \jsonSerializable {
	use ValidateUuid;
	use ValidateDate;

	/**
	 * Id and P.K for restaurant
	 * @var Uuid $restaurantId
	 */
	//declare properties
	private $restaurantId;
	/**
	 * Address for restaurants
	 * @var string $restaurantAddress
	 */
	private $restaurantAddress;
	/**
	 * name of restaurant
	 * @var string $restaurantName
	 */
	private $restaurantName;
	/**
	 *latitude of restaurant
	 * @var float restaurant latitude
	 */
	private $restaurantLat;
	/**
	 * longitude of restaurant
	 * @var float restaurant longitude
	 */
	private $restaurantLng;
	/**
	 * price of or range of price at restaurant
	 * @var string $restaurantPrice
	 */
	private $restaurantPrice;
	/**
	 * review rating for restaurant
	 * @var float $restaurantReviewRating
	 */
	private $restaurantReviewRating;
	/**
	 * Thumbnail for restaurant
	 * @var string $restaurantThumbnail
	 */
	private $restaurantThumbnail;


	/**
	 * constructor for restaurant
	 *
	 * @param string|Uuid $newRestaurantId id of restaurant
	 * @param string $newRestaurantAddress new address exists
	 * @param string $newRestaurantName new or null if exists
	 * @param float $newRestaurantLng new longitude
	 * @param float $newRestaurantLat new latitude
	 * @param string $newRestaurantPrice new price
	 * @param float $newRestaurantReviewRating new review rating
	 * @param string $newRestaurantThumbnail new exist
	 *
	 *
	 * @throws \InvalidArgumentException data types are not valid
	 * @throws \RangeException if data values entered are too long
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate hints
	 **/
	public function __construct($newRestaurantId, $newRestaurantAddress, $newRestaurantName, float $newRestaurantLat, float $newRestaurantLng, string $newRestaurantPrice, float $newRestaurantReviewRating, string $newRestaurantThumbnail = null) {
		try {
			$this->setRestaurantId($newRestaurantId);
			$this->setRestaurantAddress($newRestaurantAddress);
			$this->setRestaurantName($newRestaurantName);
			$this->setRestaurantLat($newRestaurantLat);
			$this->setRestaurantLng($newRestaurantLng);
			$this->setRestaurantPrice($newRestaurantPrice);
			$this->setRestaurantReviewRating($newRestaurantReviewRating);
			$this->setRestaurantThumbnail($newRestaurantThumbnail);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for restaurant id
	 * @return Uuid value of restaurant id
	 **/

	public function getRestaurantId(): Uuid {
		return $this->restaurantId;
	}

	/**
	 * mutator method for restaurant id
	 * @param Uuid | string $newRestaurantId new value of restaurant id
	 * @throws \RangeException if $newRestaurantId is not positive
	 * @throws \TypeError if $newRestaurantId is not a uuid or string
	 **/

	public function setRestaurantId($newRestaurantId): void {
		// verify the id a valid uuid
		try {
			$uuid = self::validateUuid($newRestaurantId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store the restaurant id
		$this->restaurantId = $uuid;
	}

	/**
	 *accessor method for the restaurant address
	 *
	 * @return restaurant address
	 */
	public function getRestaurantAddress(): string {
		return ($this->restaurantAddress);
	}

	/**
	 * mutator method for restaurant address
	 *
	 * @param string $newRestaurantAddress of restaurant address
	 * @throws \RangeException if $newRestaurantAddress is <256 characters
	 * @throws \TypeError if $newRestaurantAddress violates type hints
	 * @throws \InvalidArgumentException if $newRestaurantAddress is not a string or insecure
	 */
	public function setRestaurantAddress(string $newRestaurantAddress): void {
		// verify the restaurant address exists if not throw a suggested or close to address verify the restaurant address will fit in the database
		$newRestaurantAddress = trim($newRestaurantAddress);
		$newRestaurantAddress = filter_var($newRestaurantAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(strlen($newRestaurantAddress) > 255) {
			throw(new \RangeException("Address content too long"));
		}
		//store the restaurant address
		$this->restaurantAddress = $newRestaurantAddress;
	}

	/**mutator method for restaurant name
	 *
	 * @return string value of restaurant name
	 * */
	public function getRestaurantName(): string {
		return ($this->restaurantName);
	}

	/**
	 * Mutator method for restaurant name
	 *
	 * @param string $newRestaurantName new value of restaurant name
	 * @thorws \InvalidArgumentException if $newRestaurantName is not a string or insecure
	 * @throws \RangeException if $newRestaurantName is > 128
	 * @throws \TypeError if $newRestaurantName is not a string
	 */
	public function setRestaurantName(string $newRestaurantName): void {
		// verify the restaurant name is secure
		$newRestaurantName = trim($newRestaurantName);
		$newRestaurantName = filter_var($newRestaurantName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRestaurantName) === true) {
			throw(new \InvalidArgumentException("Restaurant name invalid "));
		}

		//verify the restaurant name will fit in the database
		if(strlen($newRestaurantName) > 128) {
			throw (new \RangeException("Name is too long"));
		}
		// store the restaurant name
		$this->restaurantName = $newRestaurantName;
	}

	/**
	 * accessor method for restaurant latitude
	 *
	 * @return float lat coordinates
	 */
	public function getRestaurantLat(): float {
		return ($this->restaurantLat);
	}

	/** mutator method for restaurantLat
	 *
	 * @param float $newRestaurantLat new value of latitude
	 * @throws \InvalidArgumentException if $newRestaurantLat is not a float or insecure
	 * @throws \RangeException if $newRestaurantLat is not within -90 to 90
	 * @throws \TypeError if $newRestaurantLat is not a float
	 **/
	public function setRestaurantLat(float $newRestaurantLat): void {
		// verify the latitude exists on earth
		if($newRestaurantLat > 90) {
			throw(new \RangeException("Location latitude is not between -90 and 90"));
		}
		if($newRestaurantLat < -90) {
			throw(new \RangeException("location latitude is not between -90 and 90"));
		}
		// store the latitude
		$this->restaurantLat = $newRestaurantLat;
	}

	/**
	 * accessor method for restaurantLng
	 *
	 * @return float longitude
	 */
	public function getRestaurantLng(): float {
		return ($this->restaurantLng);
	}

	/** mutator method for restaurantLng
	 *
	 * @param float $newRestaurantLng new value of longitude
	 * @throws \InvalidArgumentException if $newRestaurantLng is not a float or insecure
	 * @throws \RangeException if $newRestaurantLng is not within -90 to 90
	 * @throws \TypeError if $newRestaurantLng is not a float
	 **/
	public function setRestaurantLng(float $newRestaurantLng): void {
		// verify the longitude exists on earth
		if($newRestaurantLng > 180) {
			throw(new \RangeException("location longitude is not between -180 and 180"));
		}
		if($newRestaurantLng < -180) {
			throw(new \RangeException("location longitude is not between -180 and 180"));
		}
		// store the longitude
		$this->restaurantLng = $newRestaurantLng;
	}

	/**
	 *  accessor method for restaurant price
	 * @return float value of restaurant price
	 */
	public function getRestaurantPrice() {
		return ($this->restaurantPrice);
	}

	/**
	 * mutator method for restaurant price
	 * @param string $newRestaurantPrice new value of restaurant price
	 * @throws \InvalidArgumentException if $newRestaurantPrice is not a float or insecure
	 * @throws \RangeException if $newRestaurantPrice is > $0
	 * @throws \TypeError if $newRestaurantPrice is not a float
	 */
	public function setRestaurantPrice(string $newRestaurantPrice): void {
		// verify the restaurant price is secure
		$newRestaurantPrice = trim($newRestaurantPrice);
		$newRestaurantPrice = filter_var($newRestaurantPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRestaurantPrice) === true) {
			throw(new \InvalidArgumentException("$"));
		}
		// verify the restaurant price will fit into the database
		if(($newRestaurantPrice) <= 0) {
		} else {
			throw (new \RangeException("need a price"));
		}
		//store restaurant price
		$this->restaurantPrice = $newRestaurantPrice;
	}

	/**
	 * accessor method for restaurant review rating
	 *
	 * @return float value of review rating
	 **/
	public function getRestaurantReviewRating(): float {
		return ($this->restaurantReviewRating);
	}

	/**
	 * mutator method for restaurant review rating
	 *
	 * @param float $newRestaurantReviewRating new value of rating
	 * @throws \InvalidArgumentException if $newRestaurantReviewRating is not a float or insecure
	 * @throws \RangeException if $newRestaurantReviewRating is not positive
	 **/
	public Function setRestaurantReviewRating(float $newRestaurantReviewRating): void {
		// if new restaurant rating is less than min or greater than max throw range exception
		if($newRestaurantReviewRating < 0 || $newRestaurantReviewRating > 5) {
			throw(new \RangeException("Rate me"));
		}
		$this->restaurantReviewRating = $newRestaurantReviewRating;
	}

	/**mutator method for restaurant thumbnail
	 *
	 * @return string value of restaurant thumbnail
	 * */
	public function getRestaurantThumbnail(): string {
		return ($this->restaurantThumbnail);
	}

	/**
	 * Mutator method for restaurant thumbnail
	 *
	 * @param string $newRestaurantThumbnail new value of restaurant thumbnail
	 * @thorws \InvalidArgumentException if $newRestaurantThumbnail is not a string or insecure
	 * @throws \RangeException if $newRestaurantThumbnail is not a string
	 */
	public function setRestaurantThumbnail(string $newRestaurantThumbnail): void {
		// verify the restaurant thumbnail is secure
		$newRestaurantThumbnail = trim($newRestaurantThumbnail);
		$newRestaurantThumbnail = filter_var($newRestaurantThumbnail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRestaurantThumbnail) === true) {
			throw(new \InvalidArgumentException("Restaurant Thumbnail "));
		}

		//verify the restaurant thumbnail will fit in the database
		if(strlen($newRestaurantThumbnail) > 128) {
			throw (new \RangeException("too long"));
		}

		// store the restaurant name
		$this->restaurantThumbnail = $newRestaurantThumbnail;
	}

	/**
	 * inserts this Restaurant into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		//create query template
		$query = "INSERT INTO restaurant(restaurantId, restaurantAddress, restaurantName, restaurantLat, restaurantLng, restaurantPrice, restaurantReviewRating, restaurantThumbnail) VALUES(:restaurantId, :restaurantAddress, :restaurantName, :restaurantLat, :restaurantLng, :restaurantPrice, :restaurantReviewRating, :restaurantThumbnail)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["restaurantId" => $this->restaurantId->getBytes(), "restaurantAddress" => $this->restaurantAddress, "restaurantName" => $this->restaurantName, "restaurantLat" => $this->restaurantLat, "restaurantLng" => $this->restaurantLng, "restaurantPrice" => $this->restaurantPrice, "restaurantReviewRating" => $this->restaurantReviewRating, "restaurantThumbnail" => $this->restaurantThumbnail];
		$statement->execute($parameters);
	}

	/**
	 * updates this restaurant in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		//create query template
		$query = "UPDATE restaurant SET restaurantAddress = :restaurantAddress, restaurantName = :restaurantName, restaurantLat = :restaurantLat, restaurantlng = :restaurantLng, restaurantPrice = :restaurantPrice, restaurantReviewRating = :restaurantReviewRating, restaurantThumbnail = :restaurantThumbnail WHERE restaurantId = :restaurantId";
		$statement = $pdo->prepare($query);

		// bind the variables to placeholders in template
		$parameters = ["restaurantId" => $this->restaurantId->getBytes(), "restaurantAddress" => $this->restaurantAddress, "restaurantName" => $this->restaurantName, "restaurantLat" => $this->restaurantLat, "restaurantLng" => $this->restaurantLng, "restaurantPrice" => $this->restaurantPrice, "restaurantReviewRating" => $this->restaurantReviewRating, "restaurantThumbnail" => $this->restaurantThumbnail];
		$statement->execute($parameters);
	}

	/**
	 * deletes this restaurant from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM restaurant WHERE restaurantId = :restaurantId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder in the template
		$parameters = ["restaurantId" => $this->restaurantId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the restaurant by restaurantId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $restaurantId restaurant id to search for
	 * @return restaurant|null restaurant found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getRestaurantByRestaurantId(\PDO $pdo, $restaurantId): ?restaurant {
		//sanitize the restaurantId before searching
		try {
			$restaurantId = self::validateUuid($restaurantId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT restaurantId, restaurantAddress, restaurantName, restaurantLat, restaurantLng, restaurantPrice, restaurantReviewRating, restaurantThumbnail FROM restaurant WHERE restaurantId = :restaurantId";
		$statement = $pdo->prepare($query);

		// bind the restaurant id to the place holder in the template
		$parameters = ["restaurantId" => $restaurantId->getBytes()];
		$statement->execute($parameters);

		// grab the restaurant from mySQL
		try {
			$restaurant = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$restaurant = new Restaurant($row["restaurantId"], $row["restaurantAddress"], $row["restaurantName"], $row["restaurantLat"], $row["restaurantLng"], $row["restaurantPrice"], $row["restaurantReviewRating"], $row["restaurantThumbnail"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($restaurant);
	}

	/**
	 * gets all restaurant
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of restaurants found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllRestaurants(\PDO $pdo): \SPLFixedArray {
		//create query template
		$query = "SELECT restaurantId, restaurantAddress, restaurantName, restaurantLat, restaurantLng, restaurantPrice, restaurantReviewRating, restaurantThumbnail FROM restaurant";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build array of restaurants
		$restaurants = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$restaurant = new restaurant($row["restaurantId"], $row["restaurantAddress"], $row["restaurantName"], $row["restaurantLat"], $row["restaurantLng"], $row["restaurantPrice"], $row["restaurantReviewRating"], $row["restaurantThumbnail"]);
				$restaurants[$restaurants->key()] = $restaurant;
				$restaurants->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($restaurants);
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
