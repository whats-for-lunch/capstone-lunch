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
    /** id of picture that sent this from profile
     * @var Uuid  $pictureRestuarantId
     */

}//last line