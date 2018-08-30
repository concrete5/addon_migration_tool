<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

class EmptyMapper implements MapperInterface, TransformableEntityMapperInterface
{
    public function getMappedItemPluralName()
    {
        return t('Empty');
    }

    public function getTransformableEntityObjects(BatchInterface $batch)
    {
        return array();
    }

    public function getHandle()
    {
        return 'empty';
    }

    public function getItems(BatchInterface $batch)
    {
        return array();
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        return array();
    }
    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        return null;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return null;
    }
}
