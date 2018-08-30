<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface MapperInterface
{
    public function getMappedItemPluralName();
    public function getHandle();
    public function getItems(BatchInterface $batch);
    public function getInstalledTargetItems(BatchInterface $batch);
    public function getCorePropertyTargetItems(BatchInterface $batch);
    public function getBatchTargetItems(BatchInterface $batch);
    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item);
    public function getTargetItemContentObject(TargetItemInterface $targetItem);
}
