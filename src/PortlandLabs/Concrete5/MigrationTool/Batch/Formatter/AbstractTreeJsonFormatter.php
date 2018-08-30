<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractTreeJsonFormatter implements \JsonSerializable
{
    protected $entityManager;

    public function __construct(ObjectCollection $collection)
    {
        $em = \Package::getByHandle('migration_tool')->getEntityManager();
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $this->collection = $collection;
        $this->batch = $r->findFromCollection($collection);
        $this->validator = $collection->getRecordValidator($this->batch);
        $this->entityManager = $em;
    }

    protected function addMessagesNode(\stdClass $node, MessageCollection $messages)
    {
        if ($messages->count()) {
            $messageHolderNode = new \stdClass();
            $messageHolderNode->icon = $node->statusClass;
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
    }
}
