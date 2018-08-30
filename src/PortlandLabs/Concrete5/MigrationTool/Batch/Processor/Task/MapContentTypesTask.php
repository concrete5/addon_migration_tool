<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\PresetManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class MapContentTypesTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {
        $target = $action->getTarget();
        $subject = $action->getSubject();
        $batch = $target->getBatch();

        // Since batch is serialized we do this:
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($batch->getId());

        $mappers = \Core::make('migration/manager/mapping');
        $mapper = $mappers->driver($subject['mapper']);
        $targetItemList = $mappers->createTargetItemList($batch, $mapper);
        $item = new Item($subject['item']);
        $selectedTargetItem = $targetItemList->getSelectedTargetItem($item, false);
        if (!is_object($selectedTargetItem)) {
            // We're dealing with a new one that we haven't seen, so we try and assign it.
            $presetManager = new PresetManager($em);
            $targetItem = $presetManager->getMatchedTargetItem($mapper, $batch, $item);
            if (!is_object($targetItem)) {
                $targetItem = $targetItemList->getMatchedTargetItem($item);
            }
            if (is_object($targetItem)) {
                $batchTargetItem = $mappers->createBatchTargetItem();
                $batchTargetItem->setBatch($batch);
                $batchTargetItem->setTargetItem($targetItem);
                $em->persist($batchTargetItem);
                $batch->target_items->add($batchTargetItem);
                $em->persist($batch);
                $em->flush();
            }
        }
    }

    public function finish(ActionInterface $action)
    {
        return;
    }
}
