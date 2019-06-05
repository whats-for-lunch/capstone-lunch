<?php

namespace WhatsForLunch\CapstoneLunch;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

require_once(dirname(__DIR__, 1) . "/lib/uuid.php");


class DataDownloader {


	public static function pullRestaurants() {
		$newRestaurants = null;
		$urlBase = "https://api.yelp.com/v3/businesses/search?latitude=35.0856326&longitude=-106.649319";

		$secrets = new \Secrets("/etc/apache2/capstone-mysql/whatsforlunch.ini");
		$pdo = $secrets->getPdoObject();

		$yelp = $secrets->getSecret("yelp");

		$newRestaurants = self::readDataJson($urlBase, $yelp);



			var_dump($newRestaurants);

////		$thumbnailCount = 0;
//		$nameCount = 0;
//		$restaurantCount = 0;
//		$addressCount = 0;
//		foreach($newRestaurants as $value) {
//			$restaurantId = generateUuidV4();
//			$restaurantThumbnail = $value->imgSmall;
////			if(empty($restaurantThumbnail) === true) {
////				$restaurantThumbnail = "restaurant thumbnail image address";
////			}
//			//missing restaurant thumbnail counter
//
//			$restaurantName = $value->name;
//			//missing restaurant name counter
//			if((empty($restaurantName) || $restaurantName === "Needs name")===true) {
//				$restaurantName = "This restaurant does not have a name.";
//				$nameCount = $nameCount + 1;
//			}
//
//			$restaurantAddress = $value->address;
//			//missing restaurant address
//			if((empty($restaurantAddress) || $restaurantAddress === "Needs address")===true) {
//				$restaurantAddress = "This restaurant does not have an address";
//				$addressCount = $addressCount + 1;
//			}
//			$restaurantAddress = $value->address;
//			$restaurantLat = $value->latitude;
//			$restaurantLng = $value->longitude;
//			$restaurantName = $value->name;
//			$restaurantPrice = $value->price;
//			$restaurantReviewRating = $value->rating;
//			//count restaurants that are being pulled by data downloader
//			$restaurantCount = $restaurantCount + 1;
//			try {
//				$restaurant = new Restaurant($restaurantId, $restaurantAddress, $restaurantLat, $restaurantLng, $restaurantName, $restaurantPrice, $restaurantReviewRating, $restaurantThumbnail);
//				$restaurant->insert($pdo);
//			} catch(\TypeError $typeError) {
//				echo("Error Connecting to database");
//			}
//		}
	} public static function readDataJson($url, $secret) {

		var_dump($secret);
		$context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET",
				"header" => "Authorization: Bearer $secret->apiKey"
			]]);
		try {
			var_dump($context);
			//file-get-contents returns file in string context
			if(($jsonData = file_get_contents($url, null, $context)) === false) {
				throw(new \RuntimeException("url doesn't produce results"));
			}
			//decode the Json file
			$jsonConverted = json_decode($jsonData);
			//format
			$jsonFeatures = $jsonConverted->businesses;
			$newRestaurants = \SplFixedArray::fromArray($jsonFeatures);
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($newRestaurants);
	}
}

echo DataDownloader::pullRestaurants().PHP_EOL;
