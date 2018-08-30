<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ClearBatchRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        // Has the batch already been created? If so, we move to trash.
        $orphaned = \Page::getByPath('/!import_batches/' . $batch->getID(), 'RECENT', $batch->getSite());
        if (is_object($orphaned) && !$orphaned->isError()) {
            $orphaned->moveToTrash();
        }
    }
}
