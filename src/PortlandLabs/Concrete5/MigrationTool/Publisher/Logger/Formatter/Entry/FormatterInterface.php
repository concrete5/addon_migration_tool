<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

interface FormatterInterface
{

    function getEntryStatusElement(LoggableObject $object = null);
    function getDescriptionElement(LoggableObject $object = null);


}
