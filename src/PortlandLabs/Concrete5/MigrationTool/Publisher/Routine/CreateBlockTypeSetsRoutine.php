<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Block\BlockType\Set;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateBlockTypeSetsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $sets = $batch->getObjectCollection('block_type_set');

        if (!$sets) {
            return;
        }

        foreach ($sets->getSets() as $set) {
            if (!$set->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($set);
                $pkg = null;
                if ($set->getPackage()) {
                    $pkg = \Package::getByHandle($set->getPackage());
                }
                $set = Set::add($set->getHandle(), $set->getName(), $pkg);
                $logger->logPublishComplete($set);
                $types = $set->getTypes();
                foreach ($types as $handle) {
                    $bt = BlockType::getByHandle($handle);
                    if (is_object($bt)) {
                        $set->addBlockType($bt);
                    }
                }
            } else {
                $logger->logSkipped($set);
            }
        }
    }
}
