<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class ComposerControlTypeFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Composer control type %s already exists.', $object->getName());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installing composer control type %s.', $object->getName());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Composer control type %s installed.', $object->getName());
    }



}
