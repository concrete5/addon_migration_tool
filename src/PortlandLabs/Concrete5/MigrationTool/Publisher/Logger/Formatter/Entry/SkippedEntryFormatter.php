<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class SkippedEntryFormatter extends AbstractEntryFormatter
{

    public function getEntryStatusElement(LoggableObject $object = null)
    {
        $div = new Element('div', '', ['class' => 'text-muted']);
        $div->appendChild(new Element('span', t('Skipped')));
        $div->appendChild(new Element('span', ' '));
        $div->appendChild(new Element('i', '', ['class' => 'fa fa-share']));
        return $div;
    }

    public function getDescriptionElement(LoggableObject $object = null)
    {
        $formatter = $object->getLogFormatter();
        $div = new Element('div', $formatter->getSkippedDescription($object), ['class' => 'text-muted']);
        return $div;
    }


}
