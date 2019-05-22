<?php

namespace WhatsForLunch\CapstoneLunch;

require_once("autoload.php");
require_once(dirname(__DIR__) . "/Classes/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 *Small Cross section of a What's for lunch like Message
 *
 *This whats for lunch can be considered a small example of what services like whats for lunch store when messages are sent and received using whats for lunch. This can easily be extended to emulate more features of What's for Lunch.
 *
 * @author Jesse, Jamie, Jeff, <thebestjesse76@gmail.com>
 * @version 3.0.0
 **/
class Picture implements \JsonSerializable {

    use ValidateUuid;

    /**
     *id for this picture; this is the primary key
     * @var Uuid $pictureId
     **/
    private $pictureId;
    /**
     * id of picture that sent this from $pictureRestaurantId is a foreign key
     * @var Uuid $pictureRestuarantId
     **/
    private $pictureRestaurantId;

    /**
     * this is the profile picture of restaurant
     * @var string $pictureAlt
     */
    private $pictureAlt;

    /**
     * $pictureUrl to select different url from yelp
     * @var string $pictureUrl
     */
    private $pictureUrl;


    /**
     * picture constructor.
     *
     * @param string|Uuid $newPictureId of this restaurant or null if a new restaurant
     * @param string|Uuid string $newPictureRestaurantId id of the profile for the picture restaurant
     * @param string $newPictureAlt profile picture of restaurant
     * @param string $newPictureUrl string for restaurant image url
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings to long, negative integers)
     * @throws \TypeError if data types violate type hints
     * @throws \Exception if some other exception occurs
     * @Docutmentation https://php.net/manual/en/language.oop5.php
     **/
    public function __construct($newPictureId, $newPictureRestaurantId, string $newPictureAlt, string $newPictureUrl)
    {
        try {
            $this->setPictureId($newPictureId);
            $this->setPictureRestaurantId($newPictureRestaurantId);
            $this->setPictureAlt($newPictureAlt);
            $this->setPictureUrl($newPictureUrl);
        } // determined what exception type was thrown
        catch
        (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     *accessor method for picture id
     *
     * @return Uuid value of picture id
     */
    public function getPictureId(): Uuid
    {
        return ($this->pictureId);
    }
    /**mutator method for picture Id
     *
     * @param Uuid|string $newPictureId new value of picture id
     * @throw \RangeException if $newPictureId is not positive
     * @throw \TypeError if $newPictureId is not a uuid or string
     **/
    public function setPictureId($newPictureId): void
    {
        try {
            $uuid = self::validateUuid($newPictureId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        //convert and store the picture id
        $this->pictureId = $uuid;
    }


    /**
     * accessor method for picture content
     *
     * @return Uuid value of picture restaurant id
     **/
    public function getPictureRestaurantId(): Uuid
    {
        return ($this->pictureRestaurantId);
    }

    /**
     * mutator method for Picture
     * @param Uuid|string $newPictureRestaurantId new value of picture id
     * @throws \RangeException if $newPictureRestaurantId is not positive
     * @throws \TypeError if $newPictureRestaurantId is not a uuid or string
     **/
    public function setPictureRestaurantId($newPictureRestaurantId): void
    {
        try {
            $uuid = self::validateUuid($newPictureRestaurantId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
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
    public function getPictureAlt(): string
    {
        return ($this->pictureAlt);
    }


    /** mutator method for picture alternate
     *
     * @param string $newPictureAlt new value of picture alternate
     * @throws \InvalidArgumentException if $newPictureAlt is not a string or insecure
     * @throws \RangeException if $newPictureAlt is > 10 picture
     * @throws \TypeError if $newPictureAlt is not a string
     */

    public function setPictureAlt(string $newPictureAlt): void
    {
        // verify the picture alternate is secure
        $newPictureALt = trim($newPictureAlt);
        $newPictureALt = filter_var($newPictureALt, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newPictureALt) === true) {
            throw(new\InvalidArgumentException("If alternate picture is insecure."));
        }

        //verify the picture alternate will fit in the database
        if (strlen($newPictureALt) > 10) {
            throw(new \RangeException("picture can't be more than one"));
        }

        //store picture alternate
        $this->pictureAlt = $newPictureALt;
    }



    /**
     * accessor method for pictureUrl
     *
     * @return string value of pictureUrl
     */
    public function getPictureUrl(): string
    {
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
    public function setPictureUrl($newPictureUrl): void
    {

        $newPictureUrl = trim($newPictureUrl);
        $newPictureUrl = filter_var($newPictureUrl, FILTER_VALIDATE_URL);
        if (empty($newPictureUrl) === true) {
            throw(new \RangeException("Picture URL is empty or insecure"));
        }

        if (strlen($newPictureUrl) > 255) {
            throw(new \RangeException("Picture URL is too large."));
        }
        $this->pictureUrl = $newPictureUrl;
    }

    /**
     * @param \PDO $pdo PDO connection object
     * @param \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     */
    public function insert(\PDO $pdo): void
    {
        //making a query template
        $query = "INSERT INTO picture(pictureId, pictureRestaurantId, pictureAlt,  pictureUrl) VALUES (:pictureId, :pictureRestaurantId, :pictureAlt, :pictureUrl)";
        $statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
        $parameters = ["pictureId" => $this->pictureId->getBytes(), "pictureRestaurantId" => $this->getPictureRestaurantId()->getBytes(), "pictureAlt" => $this->pictureAlt, "pictureUrl" => $this->pictureUrl];
        $statement->execute($parameters);
    }

    /**
     * deletes this picture from mySQL
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @thows \TypeError if $pdo is not a PDO connection object
     */

    public function delete(\PDO $pdo): void
    {
        //create query template
        $query = "DELETE from picture WHERE pictureId = :pictureId";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holder in the template
        $parameters = ["pictureId" => $this->pictureId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * updates this picture in mySQL
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) : void
    {
        //create query template
        $query = "UPDATE picture SET pictureRestaurantId = :pictureRestaurantId, pictureAlt = :pictureAlt,  pictureUrl = :pictureUrl WHERE pictureId = :pictureId";
        $statement = $pdo->prepare($query);

        $parameters = ["pictureId" => $this->pictureId->getBytes(), "pictureRestaurantID" => $this->pictureRestaurantId->getBytes(), "pictureAlt" => $this->pictureAlt,  "pictureUrl" => $this->pictureUrl];
        $statement->execute($parameters);
    }

    /**
     * gets the picture by picture id
     * @param Uuid| string $pictureId picture id to search for
     * @param \PDO $pdo PDO connection object
     * @return picture|null Picture found or null if not found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable are not the correct data type
     */
    public static function getPictureByPictureId(\PDO $pdo, $pictureId): ?Picture
    {
        //sanitize the pictureId before searching
        try {
            $pictureId = self::validateUuid($pictureId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        //create query template
        $query = "SELECT pictureRestaurantId, pictureAlt,  pictureUrl FROM picture WHERE pictureId = :pictureId";
        $statement = $pdo->prepare($query);

        //bind the picture id to the place holder in the template
        $parameters = ["pictureId" => $pictureId->getBytes()];
        $statement->execute($parameters);
        // grab the picture from mySQL
        try {
            $picture = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $picture = new picture($row["pictureId"], $row["pictureRestaurantId"],$row["pictureAlt"],  $row["pictureUrl"]);
            }
        } catch (\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        return ($picture);
    }

    /**
     * gets the Picture by Restaurant id
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $pictureRestaurantId profile id to search by
     * @return \SplFixedArray SplFixedArray of Pictures found
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/

    public static function getPictureByPictureRestaurantId(\PDO $pdo, $pictureRestaurantId): \SplFixedArray
    {
        try {
            $pictureRestaurantId = self::validateUuid($pictureRestaurantId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

        // create query template
        $query = "SELECT pictureId, pictureAlt, pictureUrl FROM picture WHERE pictureRestaurantId = :pictureRestaurantId";
        $statement = $pdo->prepare($query);

        // bind the picture Restaurant Id to the place holder in the template
        $parameters = ["pictureRestaurantId" => $pictureRestaurantId->getBytes()];
        $statement->execute($parameters);

        // build an array of pictures
        $pictures = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                $picture = new Picture($row["pictureId"], $row["pictureRestaurantId"], $row["pictureAlt"],  $row["pictureUrl"]);
                $pictures[$pictures->key()] = $picture;
                $pictures->next();
            } catch (\Exception $exception) {

                // if the row couldn't be converted, rethrow it
                throw(new\PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($pictures);
    }
    

    /**
     * formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize(): array
    {
        $fields = get_object_vars($this);

        $fields["pictureId"] = $this->pictureId->toString();
        $fields ["pictureRestaurantId"] = $this->pictureRestaurantId->toString();
        return $fields;
    }


}//last line