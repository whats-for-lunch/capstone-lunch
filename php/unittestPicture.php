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
     * @var Profile profile
     **/
    protected $profile = null;

    /**
     * valid profile has to create the profile object to own the test
     * @var $VALID_PICTUREALT
     */
    protected $VALID_PICTUREALT = "PHPUnit test passing";

    /**
     * pictureRestaurantId
     * @var string $VALID_PICTURERESTAURANTID
     */
    protected $VALID_RESTAURANTID = "PHPUnit test still passing";
    /**
     * $pictureUrl validation
     * @var string $VALID_URL
     */
    protected $VALID_PICTUREURL = "PHPUnit test still passing";

    /**
     * valid profile hash to create the profile object to own the test
     * @var $VALID_PROFILE_HASH
     */
    protected $VALID_PROFILE_HASH;



/**
 * Class
 * create dependent objects before running each test
 * @package whatsforlunch\capstonelunch
 */
    public final function setUp () : void {
    // run the default setUp () method first
        parent::setUp();
    $password = "abc123";
    $this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" =>384]);

    // create and insert Profile to own the test Picture
        $this->profile = new Profile(generateUuidV4(), null, "@handle", "https://media.giphy.com/media/3og0INyCmH1Nylks90/giphy.gif", "test@phpunit.de", $this->VALID_PROFILE_HASH, "+12125551212");
        $this->profile->insert($this->getPDO());
    }

    /**
 * test inserting a valid Picture and verify that the actual mySQL data matches
 * @throws \Exception
 */
    public function testInsertValidPicture () : void {
    //count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("picture");

    //create a new Picture and insert to into mySQL
    $pictureId = generateUuidV4();
    $picture = new Picture($pictureId, $this->profile->getProfileId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
    $picture->insert($this->getPDO());

    //grab the data from mySQL and enforce the fields match our expectations
    $pdoPicture = Picture::getPictureByPictureId($this->getPDO(), $picture->getPictureId());
    $this->assertEquals($numRows + 1 , $this->getConnection()->getRowCount("picture"));
    $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
    $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->profile->getProfileId());
    $this->assertEquals($pdoPicture->getPictureAlt(),$this->VALID_PICTUREALT);
    $this->assertEquals($pdoPicture->getPictureUrl(), $this->VALID_PICTUREURL);
}

/**
 * test inserting a Picture, editing it, and then updating it
 */

    public function testUpdateValidPicture() : void {
        // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("picture");

    //create a new Picture and insert to into mySQL
        $pictureId = generateUuidV4();
        $picture = new Picture($pictureId, $this->profile->getProfileId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match out expectations
        $pdoPicture =Picture::getPictureByPictureId($this->getPDO(), $picture->getPictureid());
        $this->>assertEquals($pdoPicture->getPictureId(), $pictureId);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
        $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->profile->getProfileId());
        $this->assertEquals($pdoPicture->getPictureAlt(), $this->VALID_PICTUREURL);
    }
/**
 * test creating a Picture and then deleting it
 * @throws \Exception
 */

public function testDeleteValidPicture() : void {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("picture");

    //create a new Picture and insert to into mySQL
    $pictureId = generateUuidV4();
    $picture = new Picture($pictureId, $this->profile->getProfileId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
    $picture->insert($this->getPDO());

    // delete the Picture from mySQL
    $this->assEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
    $picture->delete($this->getPDO());

    //grab the data from mySQL and enforce the Picture does not exist
    $pdoPicture = Picture::getPictureByPictureRestaurantId($this->getPDO(), $picture->getPictureId());
    $this->assertNull($pdoPicture);
    $this->assertEqulas($numRows, $this->getConnection()->getRowCount("picture"));
}
/**
 * test inserting a Picture and regrabbing it form mySQL
 */
public function testGetValidPicturebyPictureRestaurantId () {
    // count the number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("picture");

    //create a new Picture and insert to into mySQL
$pictureId = generateUuidV4();
$picture = new Picture($pictureId, $this->profile->getProfileId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
$picture->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
    $results = Picture::getPictureByPictureRestaurantId($this->getPDO(), $picture->getPictureId());
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture");
    $this->assertCount(1, $results);
    $this->assertContainsOnlyInstancesOf("whatsforlunch\\capstoneLunch\\Picture", $results);

    // grab the results from the array and validate it
    $pdoPicture = $results[0];

    $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
    $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->profile->getProfileId());
    $this->assertEquals($pdoPicture->getPictureUrl(), $this->VALID_URL);
}

    public function testGetValidPicturebyPictureAlt () : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("picture");

        //create a new Picture and insert to into mySQL
        $pictureId = generageUuidV4();
        $picture = new Picture($pictureId, $this->profile->getProfileId(), $VALID_ALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = Picture::getPictureByPictureRestaurantId($this->getPDO(), $picture->getPictureAlt());
       $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
       $this->assertCount(1, $results);

       // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstanceof("whatsforlunch\capstoneLunch\Picture", $results);

        //grab the results from the array and validate it
        $pdoPicture = $results[0];
        $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
        $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->profile->getProfileId();
        $this->assertEquals($pdoPicture->getPictureAlt, $this->VALID_PICTUREURL);

}

}//last line

