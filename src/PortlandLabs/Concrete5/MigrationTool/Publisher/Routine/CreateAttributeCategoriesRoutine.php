<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateAttributeCategoriesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $categories = $batch->getObjectCollection('attribute_key_category');

        if (!$categories) {
            return;
        }

        foreach ($categories->getCategories() as $category) {
            if (!$category->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($category);
                $pkg = null;
                if ($category->getPackage()) {
                    $pkg = \Package::getByHandle($category->getPackage());
                }
                Category::add($category->getHandle(), $category->getAllowSets(), $pkg);
                $logger->logPublishComplete($category);
            } else {
                $logger->logSkipped($category);
            }
        }
    }
}
