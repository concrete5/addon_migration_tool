<?php
namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Inspector\InspectorInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AreaLayoutInspector implements InspectorInterface
{
    protected $value;

    public function __construct(AreaLayoutBlockValue $value)
    {
        $this->value = $value;
    }

    public function getMatchedItems(Batch $batch)
    {
        $layout = $this->value->getAreaLayout();
        $columns = $layout->getColumns();
        $items = array();
        foreach ($columns as $column) {
            $blocks = $column->getBlocks();
            foreach ($blocks as $block) {
                $value = $block->getBlockValue();
                $inspector = $value->getInspector();
                $items = array_merge($items, $inspector->getMatchedItems($batch));
            }
        }

        return $items;
    }
}
