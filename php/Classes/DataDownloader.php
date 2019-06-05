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


		foreach($newRestaurants as $value) {
			$restaurantId = generateUuidV4();

			$restaurantAddress = $value->location->address1;
			$restaurantLat = $value->coordinates->latitude;
			$restaurantLng = $value->coordinates->longitude;
			$restaurantName = $value->name;
			$restaurantPrice = $value->price;
			$restaurantReviewRating = $value->rating;
			$restaurantThumbnail = $value->image_url;

			try {
				$restaurant = new Restaurant($restaurantId, $restaurantAddress, $restaurantLat, $restaurantLng, $restaurantName, $restaurantPrice, $restaurantReviewRating, $restaurantThumbnail);
				$restaurant->insert($pdo);
			} catch(\TypeError $typeError) {
				echo("Error Connecting to database");
			}
		}
	}


	public static function readDataJson($url, $secret) {


		$context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET",
				"header" => "Authorization: Bearer $secret->apiKey"
			]]);
		try {

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
