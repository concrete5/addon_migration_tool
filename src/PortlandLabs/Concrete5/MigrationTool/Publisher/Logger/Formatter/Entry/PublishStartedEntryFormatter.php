<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishStartedEntryFormatter extends AbstractEntryFormatter
{

    public function getEntryStatusElement(LoggableObject $object = null)
    {
        $div = new Element('div', '', ['class' => 'text-warning']);
        $div->appendChild(new Element('span', t('Started')));
        $div->appendChild(new Element('span', ' '));
        $div->appendChild(new Element('i', '', ['class' => 'fa fa-warning']));
        return $div;
    }

    public function getDescriptionElement(LoggableObject $object = null)
    {
        if ($object) {
            $formatter = $object->getLogFormatter();
            $div = new Element('div', $formatter->getPublishStartedDescription($object), ['class' => 'text-warning']);
            return $div;
        }
    }


}
