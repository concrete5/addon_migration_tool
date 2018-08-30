<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class Exporter
{
    protected $batch;
    protected $built = false;
    protected $element;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    protected function build()
    {
        $this->element = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><concrete5-migrator></concrete5-migrator>");
        $this->element->addAttribute('version', '1.0');

        $mapping = $this->element->addChild('mapping');

        foreach($this->batch->getTargetItems() as $item) {
            $item = $item->getTargetItem();
            /**
             * @var $item TargetItem
             */
            $node = $mapping->addChild('item');
            $node->addChild('source_item_identifier', $item->getSourceItemIdentifier());
            $node->addChild('item_id', $item->getItemId());
            $node->addChild('item_type', $item->getItemType());
        }
    }

    public function getElement()
    {
        if (!$this->built) {
            $this->build();
        }

        return $this->element;
    }
}
