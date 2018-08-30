<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;

defined('C5_EXECUTE') or die("Access Denied.");

class AccessEntityValidator extends AbstractValidator
{
    public function validate($entity)
    {
        return false;
    }
}
