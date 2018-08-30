<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutine extends AbstractPageRoutine
{
    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('single_page');
    }

    public function getPageRoutineAction($page)
    {
        return new CreateSinglePageStructureRoutineAction($page);
    }
}
