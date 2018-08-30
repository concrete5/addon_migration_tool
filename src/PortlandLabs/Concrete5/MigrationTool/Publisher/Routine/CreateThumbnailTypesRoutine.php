<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateThumbnailTypesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $types = $batch->getObjectCollection('thumbnail_type');

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($type);
                $t = new \Concrete\Core\File\Image\Thumbnail\Type\Type();
                $t->setName($type->getName());
                $t->setHandle($type->getHandle());
                $t->setWidth($type->getWidth());
                $t->setHeight($type->getHeight());
                if ($type->getIsRequired()) {
                    $t->requireType();
                }
                $t->save();
                $logger->logPublishComplete($type, $t);
            } else {
                $logger->logSkipped($type);
            }
        }
    }
}
