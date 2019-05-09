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
}