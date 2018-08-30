<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Permission;

use Concrete\Core\Permission\Access\Access;
use Concrete\Core\Permission\Key\Key;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class AccessEntityPublisher implements PublisherInterface
{
    protected function getClass($entity)
    {
        $type = \Concrete\Core\Permission\Access\Entity\Type::getByHandle($entity->getType());
        $class = $type->getAccessEntityTypeClass();

        return $class;
    }

    protected function getAssignments(AccessEntity $entity)
    {
        $class = $this->getClass($entity);

        return $class::getOrCreate();
    }

    public function publish(Key $key, AccessEntity $entity)
    {
        $pa = Access::create($key);
        foreach ($this->getAssignments($entity) as $pae) {
            $pa->addListItem($pae);
        }
        $pt = $key->getPermissionAssignmentObject();
        $pt->assignPermissionAccess($pa);
    }
}
