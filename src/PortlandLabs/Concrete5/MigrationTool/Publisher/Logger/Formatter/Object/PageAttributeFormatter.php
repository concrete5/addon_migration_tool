<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class PageAttributeFormatter extends AbstractStandardFormatter
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
        return t('Setting attribute %s on page %s', $object->getHandle(), $object->getPage());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Setting attribute %s on page %s', $object->getHandle(), $object->getPage());
    }



}
