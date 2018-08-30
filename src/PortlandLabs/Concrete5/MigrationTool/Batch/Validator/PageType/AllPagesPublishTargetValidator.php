<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class AllPagesPublishTargetValidator extends AbstractValidator
{
    public function validate($entity)
    {
        $messages = new MessageCollection();

        return $messages;
    }
}
