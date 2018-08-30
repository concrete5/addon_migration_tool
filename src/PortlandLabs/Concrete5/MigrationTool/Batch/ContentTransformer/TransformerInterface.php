<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

interface TransformerInterface
{
    public function getUntransformedEntityObjects(TransformableEntityMapperInterface $mapper, BatchInterface $batch);
    public function getItem($entity);
    public function getDriver();
    public function transform($entity, MapperInterface $mapper, ItemInterface $item, TargetItem $targetItem, BatchInterface $batch);
    public function getUntransformedEntityById($entityID);

}
