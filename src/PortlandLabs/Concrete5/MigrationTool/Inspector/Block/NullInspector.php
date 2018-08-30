<?php
namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use PortlandLabs\Concrete5\MigrationTool\Inspector\InspectorInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class NullInspector implements InspectorInterface
{
    public function getMatchedItems(Batch $batch)
    {
        return [];
    }
}
