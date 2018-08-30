<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Group %s (Path: %s) already exists.', $object->getName(), $object->getPath());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installing Group %s (Path: %s) published.', $object->getName(), $object->getPath());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Group %s (Path: %s) installed.', $object->getName(), $object->getPath());
    }



}
