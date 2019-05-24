<?php
namespace WhatsForLunch\CapstoneLunch;

use WhatsForLunch\CapstoneLunch\{Profile, Picture, Test\WhatsForLunchTest};

// grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 *Full PHPUnit test for the Picture class
 *
 *This is a complete PHPUnit test of the Picture class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs
 *
 * @see \whatsforlunch\capstoneLunch\Picture
 * @author Jesus Silva <thebestJesse76@gmail.com>
 **/

class PictureTest extends WhatsForLunchTest {
    /**
     *Profile that created the picture; this is for foreign key relations
     * @var Profile profile
     **/
    protected $profile;

    /**
     * valid profile has to create the profile object to own the test
     * @var $VALID_PICTUREALT
     */
    protected $VALID_PICTUREALT = "quack";

    /**
     * pictureRestaurantId
     * @var Restaurant $VALID_PICTURERESTAURANT
     */
    protected $VALID_RESTAURANT;
    /**
     * $pictureUrl validation
     * @var string $VALID_URL
     */
    protected $VALID_PICTUREURL = "http://cats.meow/dogs.jpg";

    /**
     * Class
     * create dependent objects before running each test
     * @package whatsforlunch\capstonelunch
     */
    public final function setUp() : void {
        // run the default setUp () method first
        parent::setUp();


        $this->VALID_RESTAURANT = new Restaurant( generateUuidV4(), "123abqnewmexico", "fredricos",  30.3, 40.4, "$", 4.3, "thumbnail.jpg" );
        $this->VALID_RESTAURANT->insert($this->getPDO());

    }

    /**
     * test inserting a valid Picture and verify that the actual mySQL data matches
     * @throws \Exception
     */
    public function testInsertValidPicture() : void {
        //count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("picture");

        //create a new Picture and insert to into mySQL
        $pictureId = generateUuidV4();
        $picture = new Picture($pictureId, $this->VALID_RESTAURANT->getRestaurantId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $pdoPicture = Picture::getPictureByPictureId($this->getPDO(), $picture->getPictureId());
        $this->assertEquals($numRows + 1 , $this->getConnection()->getRowCount("picture"));
        $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
        $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->VALID_RESTAURANT->getRestaurantId());
        $this->assertEquals($pdoPicture->getPictureAlt(), $this->VALID_PICTUREALT);
        $this->assertEquals($pdoPicture->getPictureUrl(), $this->VALID_PICTUREURL);

        // $this->VALID_RESTAURANT = new Restaurant( generateUuidV4(), "123abcnewmexico", "fredricos",  30.3, 40.4, "$", 4.3, "thumbnail.jpg" );
    }

    /**
     * test inserting a Picture, editing it, and then updating it
     */

    public function testUpdateValidPicture() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("picture");

        //create a new Picture and insert to into mySQL
        $pictureId = generateUuidV4();
        $picture = new Picture($pictureId, $this->VALID_RESTAURANT->getRestaurantId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

        //edit the Picture and update it in mySQL
        $picture->setPictureAlt($this->VALID_PICTUREALT);
        $picture->update($this->getPDO());

        //grab the data from mySQL and enforce the fields match out expectations
        $pdoPicture =Picture::getPictureByPictureId($this->getPDO(), $picture->getPictureid());
        $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
        $this->assertEquals($pdoPicture->getPictureAlt(), $this->VALID_PICTUREALT);
        $this->assertEquals($pdoPicture->getPictureUrl(), $this->VALID_PICTUREURL);

        // $this->VALID_RESTAURANT = new Restaurant( generateUuidV4(), "123abcnewmexico", "fredricos",  30.3, 40.4, "$", 4.3, "thumbnail.jpg" );
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
        $picture = new Picture($pictureId, $this->VALID_RESTAURANT->getRestaurantId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

        // delete the Picture from mySQL
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
        $picture->delete($this->getPDO());

        //grab the data from mySQL and enforce the Picture does not exist
        $pdoPicture = Picture::getPictureByPictureId($this->getPDO(), $picture->getPictureId());
        $this->assertNull($pdoPicture);
        $this->assertEquals($numRows, $this->getConnection()->getRowCount("picture"));

        // $this->VALID_RESTAURANT = new Restaurant( generateUuidV4(), "123abcnewmexico", "fredricos",  30.3, 40.4, "$", 4.3, "thumbnail.jpg" );
    }
    /**
     * test inserting a Picture and grabbing it form mySQL
     */
    public function testGetValidPictureByPictureRestaurantId() {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("picture");

        //create a new Picture and insert to into mySQL
        $pictureId = generateUuidV4();
        $picture = new Picture($pictureId, $this->VALID_RESTAURANT->getRestaurantId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

//grab the data from mySQL and enforce the fields match our expectations
        $results = Picture::getPictureByPictureRestaurantId($this->getPDO(), $picture->getPictureRestaurantId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
        $this->assertCount(1, $results);
        $this->assertContainsOnlyInstancesOf("WhatsForLunch\\CapstoneLunch\\Picture", $results);

        // grab the results from the array and validate it
        $pdoPicture = $results[0];

        $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
        $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->VALID_RESTAURANT->getRestaurantId());
        $this->assertEquals($pdoPicture->getPictureAlt(), $this->VALID_PICTUREALT);
        $this->assertEquals($pdoPicture->getPictureUrl(), $this->VALID_PICTUREURL);

        // $this->VALID_RESTAURANT = new Restaurant( generateUuidV4(), "123abcnewmexico", "fredricos",  30.3, 40.4, "$", 4.3, "thumbnail.jpg" );
    }

    public function testGetValidPictureByPictureAlt() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("picture");

        //create a new Picture and insert to into mySQL
        $pictureId = generateUuidV4();
        $picture = new Picture($pictureId, $this->VALID_RESTAURANT->getRestaurantId(), $this->VALID_PICTUREALT, $this->VALID_PICTUREURL);
        $picture->insert($this->getPDO());

        //grab the data from mySQL and enforce the fields match our expectations
        $results = Picture::getPictureByPictureRestaurantId($this->getPDO(), $picture->getPictureRestaurantId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("picture"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("WhatsForLunch\CapstoneLunch\Picture", $results);

        //grab the results from the array and validate it
        $pdoPicture = $results[0];
        $this->assertEquals($pdoPicture->getPictureId(), $pictureId);
        $this->assertEquals($pdoPicture->getPictureRestaurantId(), $this->VALID_RESTAURANT->getRestaurantId());
        $this->assertEquals($pdoPicture->getPictureAlt(), $this->VALID_PICTUREALT);
        $this->assertEquals($pdoPicture->getPictureUrl(), $this->VALID_PICTUREURL);
        // $this->VALID_RESTAURANT = new Restaurant( generateUuidV4(), "123abcnewmexico", "fredricos",  30.3, 40.4, "$", 4.3, "thumbnail.jpg" );
    }

}//last line
