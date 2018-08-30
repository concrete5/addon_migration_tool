<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class ContentEditorSnippetFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Content editor snippet %s (%s) already exists.', $object->getName(), $object->getHandle());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installing conversation editor snippet %s (%s).', $object->getName(),  $object->getHandle());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Content editor snippet %s (%s) installed.', $object->getName(),  $object->getHandle());
    }



}
