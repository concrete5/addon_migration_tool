<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

interface FormatterInterface
{

    function getSkippedDescription(LoggableObject $object);
    function getPublishCompleteDescription(LoggableObject $object);
    function getPublishStartedDescription(LoggableObject $object);

}
