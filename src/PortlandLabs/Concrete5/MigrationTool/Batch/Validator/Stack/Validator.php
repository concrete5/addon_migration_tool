<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Stack;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{
    public function validate($stack)
    {
        $r = new MessageCollection();
        $blocks = $stack->getBlocks();
        $validator = \Core::make('migration/batch/block/validator', array($this->getBatch()));
        $messages = $validator->validate($blocks);
        if ($messages && count($messages)) {
            foreach ($messages as $message) {
                $r->add($message);
            }
        }

        return $r;
    }
}
