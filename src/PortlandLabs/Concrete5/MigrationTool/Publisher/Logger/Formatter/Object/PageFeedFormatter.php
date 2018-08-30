<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFeedFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Page feed %s (%s) already exists.', $object->getTitle(), $object->getHandle());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Creating page feed %s (%s).', $object->getTitle(),  $object->getHandle());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Page feed %s (%s) created.', $object->getTitle(),  $object->getHandle());
    }



}
