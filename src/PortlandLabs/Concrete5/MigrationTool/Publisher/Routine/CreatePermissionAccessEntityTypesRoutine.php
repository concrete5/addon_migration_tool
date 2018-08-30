<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Permission\Access\Entity\Type;
use Concrete\Core\Permission\Category;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePermissionAccessEntityTypesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $types = $batch->getObjectCollection('permission_access_entity_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($type);
                $pkg = null;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                $type = Type::add($type->getHandle(), $type->getName(), $pkg);
                $categories = $type->getCategories();
                foreach ($categories as $category) {
                    $co = Category::getByHandle($category);
                    if (is_object($co)) {
                        $co->associateAccessEntityType($type);
                    }
                }
                $logger->logPublishComplete($type);
            } else {
                $logger->logSkipped($type);
            }
        }
    }
}
