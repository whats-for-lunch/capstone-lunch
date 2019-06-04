<?php

namespace CapstoneTrails\AbqTrails;

require_once("autoload.php");
require_once(dirname(__DIR__,2) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");

require_once(dirname(__DIR__, 1) . "/lib/uuid.php");


class DataDownloader {

	public static function pullTrails() {
		$newTrails = null;
		$urlBase = "https://www.hikingproject.com/data/get-trails?lat=35.085470&lon=-106.649072&maxDistance=25&maxResults=500&key=200416450-0de1cd3b087cf27750e880bc07021975";
		$newTrails = self::readDataJson($urlBase);

		$secrets = new \Secrets("/etc/apache2/capstone-mysql/cohort23/trails.ini");
		$pdo = $secrets->getPdoObject();

		$avatarCount = 0;
		$descriptionCount = 0;
		$trailCount = 0;
		foreach($newTrails as $value) {
			var_dump($value->imgSmall);
			$trailId = generateUuidV4();
			$trailAvatarUrl = $value->imgSmall;
			if(empty($trailAvatarUrl) === true) {
				$trailAvatarUrl = "https://res.cloudinary.com/abq-trails/image/upload/v1552941635/abqtrail-logo-sm.jpg";
			}
			//missing avatar url counter

			$trailDescription = $value->summary;
			//missing trail description counter
			if((empty($trailDescription) || $trailDescription === "Needs Summary")===true) {
				$trailDescription = "This trail does not have a description.";
				$descriptionCount = $descriptionCount + 1;
			}
			$trailHigh = $value->high;
			$trailLatitude = $value->latitude;
			$trailLength = $value->length;
			$trailLongitude = $value->longitude;
			$trailLow = $value->low;
			$trailName = $value->name;
			//count trails that are being pulled by data downloader
			$trailCount = $trailCount + 1;
			try {
				$trail = new Trail ($trailId, $trailAvatarUrl, $trailDescription, $trailHigh, $trailLatitude, $trailLength, $trailLongitude, $trailLow, $trailName);
				$trail->insert($pdo);
			} catch(\TypeError $typeError) {
				echo("Error Connecting to database");
			}
		}
	}
	public static function readDataJson($url) {
		$context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET"]]);
		try {
			//file-get-contents returns file in string context
			if(($jsonData = file_get_contents($url, null, $context)) === false) {
				throw(new \RuntimeException("url doesn't produce results"));
			}
			//decode the Json file
			$jsonConverted = json_decode($jsonData);
			//format
			$jsonFeatures = $jsonConverted->trails;
			$newTrails = \SplFixedArray::fromArray($jsonFeatures);
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($newTrails);
	}
}

echo DataDownloader::pullTrails().PHP_EOL;