<?php

namespace whatsForLunch\capstone\test;

// ask about these.. foreign keys that I dont have
use whatsForLunch\capstone\favorite;
use whatsForLunch\capstone\picture;
use whatsForLunch\capstone\restaurant;

require_once ("whatsForLunchTesting.php");

// get the autoloader
require_once (dirname(__DIR__). "/autoloader.php");

// get the uuid generator
require_once (dirname(__DIR__,2). "/lib/uuid.php");

/**
 * Full PHPunit test of the Restaurant class
 *
 *@see restaurant
 *@author whatsForLunch capstone
 */

class restaurantTest extends whatsForLunchTesting {
	/**
	 * address for this restaurant
	 * @var string $VALID_RESTAURANTADDRESS
	 */
	protected $VALID_RESTAURANTADDRESS = "407 Hangry Ave NW";
	/**
	 * address of this restaurant
	 * @var string $VALID_RESTAURANTADDRESS2
	 */
	protected $VALID_RESTAURANTADDRESS2 = "this is still a valid address for this restaurant";
	/**
	 * name os restaurant
	 * @var string $VALID_RESTAURANTNAME
	 */
	protected $VALID_RESTAURANTNAME = "Foodz 4 Dayz";
	/**
	 * latitude coordinate for this restaurant
	 * @var float $VALID_RESTAURANTLAT
	 */
	protected $VALID_RESTAURANTLAT = 35;
	/**
	 * longitude coordinate for this restaurant
	 * @var float $VALID_RESTAURANTLNG
	 */
	protected $VALID_RESTAUTANTLNG = -106;
	/**
	 * price range at restaurant
	 * @var string $VALID_RESTAURANTPRICE
	 */
	protected $VALID_RESTAURTANTPRICE = "$$$$";
	/**
	 * Review of restaurant from yelps DB
	 * @var float $VALID_RESTAURANTREVIEWRATING
	 */
	protected $VALID_RESTAURANTREVIEWRATING = "4.5";
	/**
	 * Thumbnail for restaurant
	 * @var string $VALID_RESTAURANTTHUMBNAIL
	 */
	protected $VALID_RESTAURANTTHUMBNAIL = "img";

	/**
	 * test inserting a valid restaurant and verify that the actual mySQL data matches
	 */
public function testInsertValidRestaurant(): void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("restaurant");
	// create a new restaurant and insert into mySQL
	$restaurantId = generateUuidv4();
	$restaurant = new restaurant ($restaurantId, $this->VALID_RESTAURANTADDRESS, $this->VALID_RESTAURANTNAME, $this->VALID_RESTAURANTLAT, $this->VALID_RESTAUTANTLNG, $this->VALID_RESTAURTANTPRICE, $this->VALID_RESTAURANTREVIEWRATING, $this->VALID_RESTAURANTTHUMBNAIL);
	$restaurant->insert($this->getPDO());
// grab the data from mySQL and enforce the fields match
	$pdoRestaurant = Restaurant::getrestaurantByRestaurantId($this->getPDO(), $restaurant->getRestaurantId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("restaurant"));

	$this->assertEquals($pdoRestaurant->getRestaurantId(), $restaurantId);
	$this->assertEquals($pdoRestaurant->getRestaurantAddress(), $this->VALID_RESTAURANTADDRESS);
	$this->assertEquals($pdoRestaurant->getRestaurantName(), $this->VALID_RESTAURANTNAME);
	$this->assertEquals($pdoRestaurant->getRestaurantLat(), $this->VALID_RESTAURANTLAT);
	$this->assertEquals($pdoRestaurant->getRestaurantLng(), $this->VALID_RESTAUTANTLNG);
	$this->assertEquals($pdoRestaurant->getrestaurantPrice(), $this->VALID_RESTAURTANTPRICE);
	$this->assertEquals($pdoRestaurant->getRestaurantReviewRating(), $this->VALID_RESTAURANTREVIEWRATING);
	$this->assertEquals($pdoRestaurant->getRestaurantThumbnail(), $this->VALID_RESTAURANTTHUMBNAIL);
}

/**
 * test inserting a restaurant, editing it, and then updating it
 */
public function testUpdateValidRestaurant(): void {
	//count the number of rows and save it for later

}
}