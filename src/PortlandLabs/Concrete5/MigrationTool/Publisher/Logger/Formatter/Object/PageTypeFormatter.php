<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypeFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Page type %s already exists.', $object->getName());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installingn page type %s.', $object->getName());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Page type %s installed.', $object->getName());
    }



}
