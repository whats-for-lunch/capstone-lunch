<?php
namespace whatsforlunch\capstonelunch;

require_once ("autoload.php");
require_once (dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *Small Cross section of a What's for lunch like Message
 *
 *This whats for lunch can be considered a small example of what services like whats for lunch store when messages are sent and received using whats for lunch. This can easily be extended to emulate more features of What's for Lunch.
 *
 * @author Jesse, Jamie, Jeff, <thebestjesse76@gmail.com>
 * @version 3.0.0
 **/

class picture implements \JsonSerializable {
    use ValidateDate;
    use ValidateUuid;
    /**
     *id for this picture; this is the primary key
     *@var Uuid $pictureId
     **/
    private $pictureId;
    /**
     * id of picture that sent this from $pictureResturantId is a foreign key
     * @var Uuid  $pictureRestuarantId
     **/
    private $pictureAlt;
    /**
     * this is a alternate picture for profile
     * @var string $pictureRestaurantId
     **/
    private $pictureRestaurantId;
    /**
     * this is the profile picture of restauarant
     * @var string $pictureId
     */
    private $pictureUrl;
    /**
     *this is the web based photo for yelp
     * @var string $restuarantId
     */
    public function __construct($newPictureId, string $newPictureAlt, string $newPictureRestauarntId, string $newPictureUrl) {
        try {
            $this->setPictureId($newPictureId);
            $this->setPictureAlt($newPictureAlt);
            $this->setPictureRestaurantId($newPictureRestaurantId);
            $this->setPictureUrl($newPictureUrl);
        }
            // determined what exception type was thrown
        catch
            (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
                $exceptionType = get_class($exception);
                throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     *accessor method for picture id
     * @return Uuid value of picture id
     */
public function getPictureId() : Uuid {
    return($this->pictureId);
}
/**mutator method for picture Id
 *
 * @param Uuid|string $newPictureId new value of picture id
 * @throw \RangeException if $newPictureId is not postive
 * @throw \TypeError if $newPictureId is not a uuid or string
 **/
public function setPictureId( $newPictureId) :void {
    try {
        $uuid = self::validateUuid($newPictureId);
    } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
        $exceptionType = get_class($exception);
        throw(new $exceptionType($exception->getMessage(), 0, $exception));
    }
    //convert and store the picture id
    $this->pictureId = $uuid;
}


}//last line