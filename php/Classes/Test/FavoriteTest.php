<?php
namespace whatsforlunch\capstoneLunch;
use whatsforlunch\capstoneLunch\Favorite;
require_once("");
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
 * @see \whatsforlunch\capstoneLunch\Favorite
 * @author Jeffrey Gallegos <jgallegos362@cnm.edu>
 */

class FavoriteTest extends {
	/**
	 * Profile that created the Favorite; this is for foreign key relations
	 * @var Profile Profile
	 */
	protected $profile = null;

	
}
