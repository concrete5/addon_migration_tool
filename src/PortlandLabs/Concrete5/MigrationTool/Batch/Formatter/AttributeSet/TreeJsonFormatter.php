<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeSet;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getSets() as $set) {
            $messages = $this->validator->validate($set);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $set->getName();
            $node->handle = $set->getHandle();
            $node->exists = $set->getPublisherValidator()->skipItem();
            $node->attributes = implode(', ', $set->getAttributes());
            $node->nodetype = 'attribute_set';
            $node->extraClasses = 'migration-node-main';
            $node->id = $set->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $response[] = $node;
        }

        return $response;
    }
}
