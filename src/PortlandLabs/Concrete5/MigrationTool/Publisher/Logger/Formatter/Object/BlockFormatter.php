<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return false;
    }

    /**
     * @param Block $object
     * @return string
     */
    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Adding block %s to area %s on page %s', $object->getType(), $object->getArea(), $object->getPage());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Block %s in area %s on page %s created at ID %s.', $object->getType(), $object->getArea(), $object->getPage(), $object->getPublishedBlockID());
    }



}
