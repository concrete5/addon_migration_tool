<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry;

use HtmlObject\Element;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\FatalErrorEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class FatalErrorEntryFormatter extends AbstractEntryFormatter
{

    public function getEntryStatusElement(LoggableObject $object = null)
    {
        $div = new Element('div', '', ['class' => 'text-danger']);
        $div->appendChild(new Element('span', t('Fatal Error')));
        $div->appendChild(new Element('span', ' '));
        $div->appendChild(new Element('i', '', ['class' => 'fa fa-exclamation-circle']));
        return $div;
    }

    public function getDescriptionElement(LoggableObject $object = null)
    {
        $entry = $this->entry;
        /**
         * @var $entry FatalErrorEntry
         */
        $div = new Element('div', t('Fatal Error: %s in %s:%s', $entry->getMessage(), $entry->getFilename(), $entry->getLine()), ['class' => 'text-danger']);
        return $div;
    }


}
