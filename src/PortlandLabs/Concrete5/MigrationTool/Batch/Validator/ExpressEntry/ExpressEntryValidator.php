<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ExpressEntry;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidateProcessor;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntryValidator extends ValidateProcessor
{
    public function getTarget($mixed)
    {
        return new ExpressEntryValidatorTarget($this->getBatch(), $mixed);
    }
}
