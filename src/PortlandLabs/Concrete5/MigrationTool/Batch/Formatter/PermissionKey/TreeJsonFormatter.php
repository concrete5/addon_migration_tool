<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getKeys() as $key) {
            $messages = $this->validator->validate($key);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $key->getName();
            $node->handle = $key->getHandle();
            $node->category = $key->getCategory();
            $node->nodetype = 'permission_key';
            $node->extraClasses = 'migration-node-main';
            $node->id = $key->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            if (count($key->getAccessEntities())) {
                $entitiesHolderNode = new \stdClass();
                $entitiesHolderNode->title = t('Access');
                $entitiesHolderNode->children = array();
                $node->children[] = $entitiesHolderNode;

                foreach ($key->getAccessEntities() as $entity) {
                    $entityFormatter = $entity->getFormatter();
                    $entityNode = $entityFormatter->getBatchTreeNodeJsonObject();
                    $entitiesHolderNode->children[] = $entityNode;
                }
            }
            $response[] = $node;
        }

        return $response;
    }
}
