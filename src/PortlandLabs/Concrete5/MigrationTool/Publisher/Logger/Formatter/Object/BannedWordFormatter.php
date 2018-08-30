<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class BannedWordFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Banned word %s already imported.', $object->getWord());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Began installing banned word %s.', $object->getWord());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Banned word %s installed.', $object->getWord());
    }



}
