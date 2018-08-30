<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishTargetTypeFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Publish target type %s already exists.', $object->getName());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installing Publish target type %s.', $object->getName());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Publish target type %s installed.', $object->getName());
    }



}
