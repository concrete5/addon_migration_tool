<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\ContentImporter\ValueInspector\InspectionRoutine;

use Concrete\Core\Backup\ContentImporter\ValueInspector\InspectionRoutine\PageRoutine;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use Concrete\Package\MigrationTool\Backup\ContentImporter\ValueInspector\Item\BatchPageItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class BatchPageRoutine extends PageRoutine
{
    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    public function getItem($identifier)
    {
        $item = new BatchPageItem($this->batch, $identifier);
        return $item;
    }
}
