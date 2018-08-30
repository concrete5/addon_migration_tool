<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\User\Group\Group;

class GroupValidator extends AbstractValidator
{
    public function skipItem()
    {
        $group = Group::getByPath($this->object->getPath());

        return is_object($group);
    }
}
