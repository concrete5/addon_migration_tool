<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntry;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        /**
         * @var $entry Entry
         */
        foreach ($this->collection->getRecords() as $entry) {
            $messages = $this->validator->validate($entry);
            $formatter = $messages->getFormatter();

            $node = new \stdClass();
            $node->title = $entry->getEntity();
            $node->importID = $entry->getImportID();
            $node->label = $entry->getlabel();
            $node->exists = $entry->getPublisherValidator()->skipItem();
            $node->nodetype = 'express_entry';
            $node->extraClasses = 'migration-node-main';
            $node->id = $entry->getId();
            $node->lazy = true;

            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);

            $response[] = $node;
        }

        return $response;
    }
}
