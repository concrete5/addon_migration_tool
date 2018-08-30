<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageFeed;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getFeeds() as $feed) {
            $messages = $this->validator->validate($feed);
            $formatter = $messages->getFormatter();
            $node = new \stdClass();
            $node->title = $feed->getTitle();
            $node->handle = $feed->getHandle();
            $node->nodetype = 'page_feed';
            $node->exists = $feed->getPublisherValidator()->skipItem();
            $node->extraClasses = 'migration-node-main';
            $node->id = $feed->getId();
            $node->statusClass = $formatter->getCollectionStatusIconClass();
            $this->addMessagesNode($node, $messages);
            $response[] = $node;
        }

        return $response;
    }
}
