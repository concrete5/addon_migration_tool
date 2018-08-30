<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\User;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getUsers() as $user) {
            $messages = $this->validator->validate($user);
            $formatter = $messages->getFormatter();

            $node = new \stdClass();
            $node->title = $user->getName();
            $node->lazy = true;
            $node->nodetype = 'user';
            $node->extraClasses = 'migration-node-main';

            $publisherValidator = $user->getPublisherValidator();
            $skipItem = $publisherValidator->skipItem();
            if ($skipItem) {
                $node->extraClasses .= ' migration-item-skipped';
            } else {
                $node->statusClass = $formatter->getCollectionStatusIconClass();
            }

            $node->id = $user->getId();
            $node->uEmail = $user->getEmail();
            $response[] = $node;
        }

        return $response;
    }
}
