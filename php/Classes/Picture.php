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
     * id of picture that sent this from $pictureRestaurantId is a foreign key
     * @var Uuid  $pictureRestuarantId
     **/
    private $pictureAlt;
    /**
     * this is a alternate picture for profile
     * @var string $pictureRestaurantId
     **/
    private $pictureRestaurantId;
    /**
     * this is the profile picture of restaurant
     * @var string $pictureId
     */
    private $pictureUrl;
    /**
     *this is the web based photo for yelp
     * @var string $restuarantId
     */

    /**
     * picture constructor.
     * @param $newPictureId
     * @param string $newPictureAlt
     * @param string $newPictureRestaurantId
     * @param string $newPictureUrl
     * @throws \InvalidArgumentException
     * @throws \RangeException
     * @throws \TypeError
     * @throws \Exception
     * @Docutmentation https://php.net/manual/en/language.oop5.php
     **/
    public function __construct($newPictureId, string $newPictureAlt, string $newPictureRestaurantId, string $newPictureUrl) {
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
     *
     * @return Uuid value of picture id
     */
public function getPictureId() : Uuid {
    return($this->pictureId);
}

/**mutator method for picture Id
 *
 * @param Uuid|string $newPictureId new value of picture id
 * @throw \RangeException if $newPictureId is not positive
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
/**
 * accessor method for picture content
 *
 * @return string value of picture content
 **/
public function getPictureRestaurantId () : Uuid {
    return($this->pictureRestaurantId);
}
/**
 * mutator method for Picture
 * @param Uuid\string $newPictureRestaurantId new value of picture id
 * @throws \RangeException if $newPictureRestaurantId is not postive
 * @throws \TypeError if $newPictureRestaurantId is not a uuid or string
 **/
public function setPictureRestaurantId($newPictureRestaurantId) : void {
    try {
        $uuid = self::validateUuid($newPictureRestaurantId);
    } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
        $exceptionType = get_class($exception);
        throw(new $exceptionType($exception->getMessage(), 0, $exception));
    }
    //convert and store the picture id
    $this->pictureRestaurantId = $uuid;
}

/**
 * accessor method for picture profile id
 *
 * @return Uuid value of picture profile id
 */
    public function getPictureAlt() : string {
        return($this->pictureAlt);
    }
    /** mutator method for picture alternate
     *
     *@param string $newPictureAlt new value of picture alternate
     *@throws \InvalidArgumentException if $newPictureAlt is not a string or insecure
     *@throws \RangeException if $newPictureAlt is > 1 picture
     *@throws \TypeError if $newPictureAlt is not a string
     */

public function setPictureAlt(string $newPictureAlt) : void {
    // verify the picture alternate is secure
    $newPictureALt = trim($newPictureAlt);
    $newPictureALt = filter_var($newPictureALt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    if(empty($newPictureALt) === true){
        throw(new\InvalidArgumentException("If alternate picture is insecure."));
    }

    //verify the picture alternate will fit in the database
    if(strlen($newPictureALt) > 1){
        throw(new\RangeException("picture can't be more than one"));
    }

    //store picture alternate
    $this->pictureAlt = $newPictureALt;
}
/**
 * accessor method for pictureUrl
 *
 * @return string value of pictureUrl
 */
public function getPictureUrl(): string {
    return ($this->pictureUrl);
}

/**
 * mutator method for pictureUrl
 *
 * @param string $newPictureUrl
 * @throws \InvalidArgumentException if $newPictureUrl is not a string or insecure
 * @throws \RangeException if the Url is not < 255 characters
 * @throws \TypeError if the Url is not a string
 */
public function setPictureUrl($newPictureUrl) : void {
    $newPictureUrl = trim($newPictureUrl);
    $newPictureUrl = filter_var($newPictureUrl, FILTER_VALIDATE_URL);
    if(empty($newPictureUrl) === true){
        throw(new \RangeException("Picture URL is empty or insecure"));
    }
    if(strlen($newPictureUrl)>255){
        throw(new \RangeException("Picture URL is too large"));
    }
    this->$this->pictureUrl = $newPictureUrl;
}

    /**
     * @param \PDO $pdo PDO connection object
     * @param \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
public function insert(\PDO $pdo) : void {
    //making a query template
    $query = "INSERT INTO picture(pictureId, pictureAlt, pictureRestaurantId, pictureUrl) VALUES (:pictureId, :pictureAlt, :pictureRestaurantId, :pictureUrl)";
    $statement = $pdo->prepare($query);

    $parameters = ["pictureId" => $this->pictureId->getBytes()];
    $statement->execute($parameters);
}
public function delete (\PDO $pdo) : void {
    $query = "DELETE from picture WHERE pictureId = :pictureId"
}





}//last line