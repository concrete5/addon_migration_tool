<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class ConfigValueFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Config value for key %s already exists.', $object->getConfigKey());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installing config value for key %s.', $object->getConfigKey());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Config value for key %s installed.', $object->getConfigKey());
    }



}
