<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class TransformContentTypesTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        $em = \Database::connection()->getEntityManager();
        $target = $action->getTarget();
        $subject = $action->getSubject();
        $batch = $target->getBatch();

        $transformers = \Core::make('migration/manager/transforms');
        $mappers = \Core::make('migration/manager/mapping');
        $transformer = $transformers->driver($subject['transformer']);
        $entity = $transformer->getUntransformedEntityByID($subject['entity']);
        if (is_object($entity)) {
            $item = $transformer->getItem($entity);

            // Since batch is serialized we do this:
            $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($batch->getId());
            $mapper = $mappers->driver($subject['mapper']);

            if (is_object($item)) {
                $targetItemList = $mappers->createTargetItemList($batch, $mapper);
                $targetItem = $targetItemList->getSelectedTargetItem($item);
                if (is_object($targetItem)) {
                    if ($targetItem instanceof IgnoredTargetItem || $targetItem instanceof UnmappedTargetItem) {
                        return;
                    }

                    $transformer->transform($entity, $mapper, $item, $targetItem, $batch);
                    $em->flush();
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
        return;
    }
}
