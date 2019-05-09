<?php

namespace whatsforlunch\capstonelunch;

require_once (dirname(__DIR__) .  "/classes/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Favorite class for the users of the whatsforlunch application
 * This Favorite class describes the attributes that make up the user's favorite list.
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */

class Favorite {
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

}