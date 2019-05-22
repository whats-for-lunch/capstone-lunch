<?php
namespace WhatsForLunch\CapstoneLunch\Test;

use WhatsForLunch\CapstoneLunch\{Favorite, Profile, Restaurant};

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Favorite Class
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods are
 * tested for both invalid and valid inputs
 *
 * @see \WhatsForLunch\CapstoneLunch\Favorite
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */


class FavoriteTest extends WhatsForLunchTest {

	/**
	 * Profile that created the Favorite; this is for foreign key relations
	 * @var Profile Profile
	 */
	protected $profile = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * valid activation token
	 * @var string $profileActivationToken
	 */
	protected $VALID_ACTIVATION_TOKEN = null;

	/**
	 * Restaurant that created the Favorite; this is for foreign key relations
	 * @var string $restaurant
	 */
	protected $restaurant = null;

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp() : void {
		//run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION_TOKEN = bin2hex(random_bytes(16));

		//create and insert a Profile to the test Favorite
		$profileId = generateUuidV4();
		$this->profile = new Profile($profileId, $this->VALID_ACTIVATION_TOKEN,"test@test.com","Herbert",
			"McGroober", $this->VALID_PROFILE_HASH);
			$this->profile->insert($this->getPDO());

		//create and insert restaurant to test favorite
		$restaurantId = generateUuidV4();
		$this->restaurant = new Restaurant($restaurantId, "200 3rd St NW, Albuquerque, NM 87102",
			"Friends Coffee & Sandwich Shop", 35.085529, -106.650085,
			"$2-$8", 4.8, "http://fcass.com/");
			$this->restaurant->insert($this->getPDO());
	}

	/**
	 * test inserting a valid favorite and verify that the actual mySQL data matches
	 */
	public function testInsertValidFavorite() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->restaurant->getRestaurantId());
			$favorite->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $this->restaurant->getRestaurantId(),
		$this->profile->getProfileId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteRestaurntId(), $this->restaurant->getRestaurantId());
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
	}

	/**
	 * test creating a favorite and then deleting
	 */
	public function testDeleteValidFavorite() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create a new favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->restaurant->getRestaurantId());
			$favorite->insert($this->getPDO());

		//delete the favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		//grab data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $favorite->getFavoriteRestaurantId(), $favorite->getFavoriteProfileId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/**
	 * gets the favorite by favoriteProfileId
	 */
	public function testGetValidFavoriteByFavoriteProfileId() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create new favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->restaurant->getRestaurantId());
			$favorite->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $favorite->getFavoriteProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("WhatsForLunch\\CapstoneLunch\\Favorite", $results);

		//grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteRestaurantId(), $this->restaurant->getRestaurantId());
	}

	/**
	 * gets the favorite by FavoriteRestaurantId
	 */
	public function testGetValidFavoriteByFavoriteRestaurantId() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		//create new favorite and insert into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->restaurant->getRestaurantId());
			$favorite->insert($this->getPDO());

		//grab data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteRestaurantId($this->getPDO(), $favorite->getFavoriteRestaurantId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("WhatsForLunch\\CapstoneLunch\\Favorite", $results);

		//grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteRestaurantId(), $this->restaurant->getRestaurantId());
	}



}
