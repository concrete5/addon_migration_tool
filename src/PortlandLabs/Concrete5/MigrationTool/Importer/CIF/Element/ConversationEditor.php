<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\Editor;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\EditorObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ConversationEditor implements ElementParserInterface
{
    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $collection = new EditorObjectCollection();
        if ($this->simplexml->conversationeditors->editor) {
            foreach ($this->simplexml->conversationeditors->editor as $node) {
                $editor = new Editor();
                $editor->setHandle((string) $node['handle']);
                $editor->setName((string) $node['name']);
                if ((string) $node['activated'] == '1') {
                    $editor->setIsActive(true);
                }
                $editor->setPackage((string) $node['package']);
                $collection->getEditors()->add($editor);
                $editor->setCollection($collection);
            }
        }

        return $collection;
    }
}
