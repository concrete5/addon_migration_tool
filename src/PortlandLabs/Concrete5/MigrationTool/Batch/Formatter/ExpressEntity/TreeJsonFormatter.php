<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entity;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        /**
         * @var $entity Entity
         */
        foreach ($this->collection->getRecords() as $entity) {
            $messages = $this->validator->validate($entity);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $entity->getName();
            $node->exists = $entity->getPublisherValidator()->skipItem();
            $node->nodetype = 'express_entity';
            $node->extraClasses = 'migration-node-main';
            $node->id = $entity->getId();
            $node->handle = $entity->getHandle();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);

            $associationsHolderNode = new \stdClass();
            $associationsHolderNode->icon = 'fa fa-cubes';
            $associationsHolderNode->title = t('Associations');
            $associationsHolderNode->children = array();

            $associations = $entity->getAssociations();
            foreach($associations as $association) {
                $type = '';
                switch((string) $association->getType()) {
                    case 'one_to_many':
                        $type = t('One-To-Many');
                        break;
                    case 'many_to_one':
                        $type = t('Many-To-One');
                        break;
                    case 'one_to_one';
                        $type = t('One-To-One');
                        break;
                    case 'many_to_many':
                        $type = t('Many-To-Many');
                        break;
                }
                $associationNode = new \stdClass();
                $associationNode->title = $type;
                $associationNode->itemvalue = $association->getTargetPropertyName();
                $associationNode->icon = 'fa fa-list-alt';
                $associationsHolderNode->children[] = $associationNode;
            }

            $attributesHolderNode = new \stdClass();
            $attributesHolderNode->icon = 'fa fa-cog';
            $attributesHolderNode->title = t('Attribute Keys');
            $attributesHolderNode->children = array();

            $attributes = $entity->getAttributeKeys();
            foreach($attributes->getKeys() as $key) {
                $attributeNode = new \stdClass();
                $attributeNode->title = $key->getName();
                $attributeNode->itemvalue = $key->getType();
                $attributeFormatter = $key->getFormatter();
                $attributeDataNode = $attributeFormatter->getBatchTreeNodeJsonObject();
                if ($attributeDataNode) {
                    $attributeNode->children[] = $attributeDataNode;
                }
                $attributesHolderNode->children[] = $attributeNode;
            }



            $formsHolderNode = new \stdClass();
            $formsHolderNode->icon = 'fa fa-file';
            $formsHolderNode->title = t('Forms');
            $formsHolderNode->children = array();

            $forms = $entity->getForms();
            foreach($forms as $form) {
                $formNode = new \stdClass();
                $formNode->title = $form->getName();
                $formNode->children = [];
                foreach($form->getFieldSets() as $set) {
                    $setNode = new \stdClass();
                    $setNode->title = t('Field Set');
                    $setNode->itemvalue = $set->getTitle();
                    foreach($set->getControls() as $control) {
                        $controlNode = new \stdClass();
                        $formatter = $control->getFormatter();
                        $controlNode->title = $formatter->getControlLabel();
                        $controlNode->itemvalue = $formatter->getControlTypeText();
                        $controlNode->icon = $formatter->getIconClass();
                        $setNode->children[] = $controlNode;
                    }
                    $formNode->children[] = $setNode;
                }
                $formsHolderNode->children[] = $formNode;
            }


            $node->children[] = $associationsHolderNode;
            $node->children[] = $attributesHolderNode;
            $node->children[] = $formsHolderNode;


            $response[] = $node;
        }

        return $response;
    }
}
