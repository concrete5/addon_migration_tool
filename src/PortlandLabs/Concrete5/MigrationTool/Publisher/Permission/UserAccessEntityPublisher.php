<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Permission;

use Concrete\Core\Permission\Access\Access;
use Concrete\Core\User\UserInfo;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class UserAccessEntityPublisher extends AccessEntityPublisher
{
    protected function getAssignments(AccessEntity $entity)
    {
        $class = $this->getClass($entity);
        $ui = UserInfo::getByUserName($entity->getUserName());

        return $class::getOrCreate($ui);
    }
}
