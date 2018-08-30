<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidateProcessor;

defined('C5_EXECUTE') or die("Access Denied.");

class CollectionValidator extends ValidateProcessor
{
    public function getTarget($mixed)
    {
        return new CollectionValidatorTarget($this->getBatch(), $mixed);
    }
}
