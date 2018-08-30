<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Site;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getSites() as $site) {

            $messages = $this->validator->validate($site);
            $formatter = $messages->getFormatter();

            $node = new \stdClass();
            $node->title = $site->getName();
            $node->lazy = true;
            $node->nodetype = 'site';
            $node->extraClasses = 'migration-node-main';

            $publisherValidator = $site->getPublisherValidator();
            $skipItem = $publisherValidator->skipItem();
            if ($skipItem) {
                $node->extraClasses .= ' migration-item-skipped';
            } else {
                $node->statusClass = $formatter->getCollectionStatusIconClass();
            }

            $node->id = $site->getId();
            $node->siteHandle = $site->getHandle();
            $node->siteType = $site->getType();
            $response[] = $node;
        }

        return $response;
    }
}
