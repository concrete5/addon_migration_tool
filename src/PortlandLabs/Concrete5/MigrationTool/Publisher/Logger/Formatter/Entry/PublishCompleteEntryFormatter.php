<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishCompleteEntryFormatter extends AbstractEntryFormatter
{

    public function getEntryStatusElement(LoggableObject $object = null)
    {
        $div = new Element('div', '', ['class' => 'text-success']);
        $div->appendChild(new Element('span', t('Complete')));
        $div->appendChild(new Element('span', ' '));
        $div->appendChild(new Element('i', '', ['class' => 'fa fa-thumbs-up']));
        return $div;
    }

    public function getDescriptionElement(LoggableObject $object = null)
    {
        $formatter = $object->getLogFormatter();
        $div = new Element('div', $formatter->getPublishCompleteDescription($object), ['class' => 'text-success']);
        return $div;
    }


}
