<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Permission;

use Concrete\Core\Permission\Key\Key;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    public function publish(Key $key, AccessEntity $entity);
}
