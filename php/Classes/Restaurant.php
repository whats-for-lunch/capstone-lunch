<?php
namespace whatsForLunch\capstoneLunch;
require_once ("autoload.php");
require_once (dirname(__DIR__) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * create a class for restaurant in project 'What's for lunch?'
 */

class restaurant{
	use validateUuid;
	use ValidateDate;
	/**
	 * Id and P.K for restaurant
	 * @var string Uuid $restaurantId
	 */
	private $restaurantId;
	/**
	 * Address for restaurants
	 * @var $restaurantAddress
	 */
	private $restaurantAddress;
	/**
	 * name of restaurant
	 * @var $restaurantName
	 */
	private $restaurantName;
	/**
	 * longitude of restaurant
	 * @decimal $restaurantLng
	 */
	private $restaurantLng;
	/**
	 *latitude of restaurant
	 * @decimal $restaurantLat
	 */
	private $restaurantLat;
	/**
	 * price of or range of price at restaurant
	 * @var $restaurantPrice
	 */
	private $restaurantPrice;
	/**
	 * review rating for restaurant
	 * @decimal $restaurantReviewRating
	 */
	private $restaurantReviewRating;
	/**
	 * Thumbnail for restaurant
	 * @var $restaurantThumbnail
	 */
	private $restaurantThumbnail
}
