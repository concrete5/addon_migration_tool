<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getTypes() as $type) {
            $messages = $this->validator->validate($type);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $type->getName();
            $node->handle = $type->getHandle();
            $node->nodetype = 'page_type';
            $node->exists = $type->getPublisherValidator()->skipItem();
            $node->extraClasses = 'migration-node-main';
            $node->id = $type->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();

            $this->addMessagesNode($node, $messages);
            $targetFormatter = $type->getPublishTarget()->getFormatter();
            $targetNode = $targetFormatter->getBatchTreeNodeJsonObject();
            if ($targetNode) {
                $node->children[] = $targetNode;
            }

            $composerFormHolderNode = new \stdClass();
            $composerFormHolderNode->title = t('Compose Form');
            $composerFormHolderNode->iconclass = 'fa fa-list-alt';
            $composerFormHolderNode->children = array();

            foreach ($type->getLayoutSets() as $set) {
                $setNode = new \stdClass();
                $setNode->title = $set->getName();
                foreach ($set->getControls() as $control) {
                    $controlNode = new \stdClass();
                    $controlNode->title = $control->getLabel();
                    $setNode->children[] = $controlNode;
                }
                $composerFormHolderNode->children[] = $setNode;
            }

            $node->children[] = $composerFormHolderNode;

            $defaultsHolderNode = new \stdClass();
            $defaultsHolderNode->iconclass = 'fa fa-font';
            $defaultsHolderNode->title = t('Page Defaults');
            $defaultsHolderNode->children = array();

            $defaultPages = $type->getDefaultPageCollection();
            foreach ($defaultPages->getPages() as $page) {
                $pageFormatter = $messages->getFormatter();
                $pageNode = new \stdClass();
                $pageNode->title = t('Template: %s', $page->getTemplate());
                $pageNode->lazy = true;
                $pageNode->nodetype = 'page';
                $pageNode->id = $page->getId();
//                $pageNode->statusClass = $pageFormatter->getCollectionStatusIconClass();
                $defaultsHolderNode->children[] = $pageNode;
            }
            $node->children[] = $defaultsHolderNode;
            $response[] = $node;
        }

        return $response;
    }
}
