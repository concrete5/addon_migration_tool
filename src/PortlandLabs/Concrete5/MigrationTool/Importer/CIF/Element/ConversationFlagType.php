<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Conversation\FlagTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ConversationFlagType implements ElementParserInterface
{
    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $collection = new FlagTypeObjectCollection();
        if ($this->simplexml->flag_types->flag_type) {
            foreach ($this->simplexml->flag_types->flag_type as $node) {
                $type = new FlagType();
                $type->setHandle((string) $node);
                $type->setPackage((string) $node['package']);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }

        return $collection;
    }
}
