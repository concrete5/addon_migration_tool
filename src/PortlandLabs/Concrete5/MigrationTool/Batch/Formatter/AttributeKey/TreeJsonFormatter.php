<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getRecords() as $key) {
            $messages = $this->validator->validate($key);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $key->getName();
            $node->exists = $key->getPublisherValidator()->skipItem();
            $node->nodetype = 'attribute_key';
            $node->extraClasses = 'migration-node-main';
            $node->id = $key->getId();
            $node->handle = $key->getHandle();
            $node->type = $key->getType();
            $node->category = (string) $key->getCategory();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $attributeCategoryFormatter = $key->getCategory()->getFormatter();
            if (is_object($attributeCategoryFormatter)) {
                $attributeCategoryNode = $attributeCategoryFormatter->getBatchTreeNodeJsonObject();
                if ($attributeCategoryNode) {
                    $node->children[] = $attributeCategoryNode;
                }
            }
            $attributeFormatter = $key->getFormatter();
            $attributeNode = $attributeFormatter->getBatchTreeNodeJsonObject();
            if ($attributeNode) {
                $node->children[] = $attributeNode;
            }
            $response[] = $node;
        }

        return $response;
    }
}
