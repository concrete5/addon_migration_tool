<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Site;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidateProcessor;

defined('C5_EXECUTE') or die("Access Denied.");

class SiteValidator extends ValidateProcessor
{
    public function getTarget($mixed)
    {
        return new SiteValidatorTarget($this->getBatch(), $mixed);
    }
}
