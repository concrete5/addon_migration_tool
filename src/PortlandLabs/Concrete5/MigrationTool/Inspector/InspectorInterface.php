<?php
namespace PortlandLabs\Concrete5\MigrationTool\Inspector;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface InspectorInterface
{
    public function getMatchedItems(Batch $batch);
}
