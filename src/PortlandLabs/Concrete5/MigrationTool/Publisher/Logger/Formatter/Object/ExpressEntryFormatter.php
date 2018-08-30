<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\ExpressEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntryFormatter extends AbstractStandardFormatter
{

    /**
     * @param ExpressEntry $object
     * @return string
     */
    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Entry %s (ID: %s) already exists.', $object->getComputedName(), $object->getId());
    }

    /**
     * @param Page $object
     * @return string
     */
    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Creating entry %s (ID: %s)', $object->getComputedName(), $object->getId());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Entry %s created at ID %s.', $object->getComputedName(), $object->getPublishedEntry()->getId());
    }



}
