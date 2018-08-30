<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageTypeComposerControlTypesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $types = $batch->getObjectCollection('page_type_publish_target_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($type);
                $pkg = false;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                \Concrete\Core\Page\Type\Composer\Control\Type\Type::add($type->getHandle(), $type->getName(), $pkg);
                $logger->logPublishComplete($type);
            } else {
                $logger->logSkipped($type);
            }
        }
    }
}
