<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidateProcessor;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends ValidateProcessor
{
    public function getTarget($mixed)
    {
        return new ValidatorTarget($this->getBatch(), $mixed);
    }
}
