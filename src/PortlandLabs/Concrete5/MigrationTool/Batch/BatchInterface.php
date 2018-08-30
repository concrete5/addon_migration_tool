<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch;

interface BatchInterface
{
    public function getObjectCollections();
    public function getObjectCollection($collection);
    public function getSite();
}
