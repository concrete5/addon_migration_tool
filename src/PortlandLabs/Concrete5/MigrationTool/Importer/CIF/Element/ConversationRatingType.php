<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\RatingType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\RatingTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ConversationRatingType implements ElementParserInterface
{
    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $collection = new RatingTypeObjectCollection();
        if ($this->simplexml->conversationratingtypes->conversationratingtype) {
            foreach ($this->simplexml->conversationratingtypes->conversationratingtype as $node) {
                $type = new RatingType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setPoints((string) $node['points']);
                $type->setPackage((string) $node['package']);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }

        return $collection;
    }
}
