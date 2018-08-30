<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface TransformableEntityMapperInterface
{
    public function getTransformableEntityObjects(BatchInterface $batch);
}
