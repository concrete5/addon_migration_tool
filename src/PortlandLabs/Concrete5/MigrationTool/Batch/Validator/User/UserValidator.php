<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\User;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidateProcessor;

defined('C5_EXECUTE') or die("Access Denied.");

class UserValidator extends ValidateProcessor
{
    public function getTarget($mixed)
    {
        return new UserValidatorTarget($this->getBatch(), $mixed);
    }
}
