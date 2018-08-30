<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Stack\Stack;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateStackStructureRoutine extends AbstractPageRoutine
{
    public function getPageRoutineAction($page)
    {
        return new CreateStackStructureRoutineAction($page);
    }

    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('stack');
    }

    public function getPages(ObjectCollection $collection)
    {
        return $collection->getStacks();
    }
}
