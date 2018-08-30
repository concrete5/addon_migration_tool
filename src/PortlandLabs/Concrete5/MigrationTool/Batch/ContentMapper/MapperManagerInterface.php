<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface MapperManagerInterface
{
    public function createTargetItemList(BatchInterface $batch, MapperInterface $mapper);
    public function createBatchTargetItem();
}
