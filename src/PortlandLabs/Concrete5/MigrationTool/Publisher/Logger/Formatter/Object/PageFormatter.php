<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Page %s (Path: %s) already exists.', $object->getName(), $object->getBatchPath());
    }

    /**
     * @param Page $object
     * @return string
     */
    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Creating page %s (Path: %s)', $object->getName(), $object->getBatchPath());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Page %s (Path: %s) created at ID %s.', $object->getName(), $object->getBatchPath(), $object->getPublishedPageID());
    }



}
