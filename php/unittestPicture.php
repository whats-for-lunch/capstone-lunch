<?php
namespace whatsforlunch\capstonelunch;

use whatsforlunch\capstoneLunch\{Picture};

// grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once (dirname_(__DIR__, 2) . "/uuid.php");

/**
 *Full PHPUnit tewst for the Picture class
 *
 *This is a complete PHPUnit test of the Picture class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs
 *
 * @see \whatsforlunch\capstoneLunch\Picture
 * @author Jesus Silva <thebestJesse76@gmail.com>
 **/

class PictureTest extends DataDesignTest {
    /**
     *Profile that created the picture; this is for foreign key relations
     *@var Profile profile
     **/
    protected $profile = null;

    /**
     * valid profile has to create the profile object to own the test
     * @var $VALID_PICTUREALT
     */
    protected $VALID_PICTUREALT = "PHPUnit test passing";
    /**
     * content of the picture
     * @var string $VALID_PICTUREALT
     */
    protected $VALID_PICTUREALT = "PHPUnit test still passing";
}//last line