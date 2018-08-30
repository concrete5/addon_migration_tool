<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Job\Job;
use Concrete\Core\User\UserInfo;

class UserValidator extends AbstractValidator
{
    public function skipItem()
    {
        $user = UserInfo::getByUserName($this->object->getName());

        return is_object($user);
    }
}
