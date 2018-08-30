<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();

        $r = \Database::connection()->getEntityManager()->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');

        foreach ($this->collection->getStacks() as $stack) {
            $messages = $this->validator->validate($stack);
            $stackFormatter = $stack->getStackFormatter();
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $stack->getName();
            $node->stackType = $stack->getType();
            $node->pagePath = $stack->getPath();
            $node->icon = $stackFormatter->getIconClass();
            $node->nodetype = 'stack';
            $node->exists = $stack->getPublisherValidator()->skipItem();
            $node->extraClasses = 'migration-node-main';
            $node->id = $stack->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $node->children = [];

            $batch = $r->findFromCollection($this->collection);
            $validator = $this->collection->getRecordValidator($batch);
            $messages = $validator->validate($stack);
            if ($messages->count()) {
                $messageHolderNode = new \stdClass();
                $messageHolderNode->icon = $messages->getFormatter()->getCollectionStatusIconClass();
                $messageHolderNode->title = t('Errors');
                $messageHolderNode->children = array();
                foreach ($messages as $m) {
                    $messageNode = new \stdClass();
                    $messageNode->icon = $m->getFormatter()->getIconClass();
                    $messageNode->title = $m->getFormatter()->output();
                    $messageHolderNode->children[] = $messageNode;
                }
                $node->children[] = $messageHolderNode;
            }

            if (count($stack->getBlocks()) > 0) {
                $holderNode = new \stdClass();
                $holderNode->icon = 'fa fa-cubes';
                $holderNode->title = t('Blocks');
                foreach ($stack->getBlocks() as $block) {
                    $value = $block->getBlockValue();
                    if (is_object($value)) {
                        $blockFormatter = $value->getFormatter();
                        $blockNode = $blockFormatter->getBatchTreeNodeJsonObject();
                        if ($styleSet = $block->getStyleSet()) {
                            $styleSetFormatter = new StyleSetTreeJsonFormatter($styleSet);
                            $blockNode->children[] = $styleSetFormatter->getBatchTreeNodeJsonObject();
                        }
                        $holderNode->children[] = $blockNode;
                    }
                }
                $node->children[] = $holderNode;
            }

            $response[] = $node;

        }

        return $response;
    }
}
