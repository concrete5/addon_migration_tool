<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Permission;

use Concrete\Core\Permission\Access\Access;
use Concrete\Core\User\Group\Group;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupAccessEntityPublisher extends AccessEntityPublisher
{
    protected function getAssignments(AccessEntity $entity)
    {
        $class = $this->getClass($entity);
        $g = Group::getByName($entity->getGroupName());

        return $class::getOrCreate($g);
    }
}
