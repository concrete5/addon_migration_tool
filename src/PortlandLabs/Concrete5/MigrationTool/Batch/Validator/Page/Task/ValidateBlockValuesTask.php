<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateBlockValuesTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        $blocks = $action->getSubject();
        $target = $action->getTarget();
        foreach($blocks as $block) {
            $value = $block->getBlockValue();
            if ($value) {
                $validator = $value->getRecordValidator($target->getBatch());
                if (is_object($validator)) {
                    $r = $validator->validate($value);
                    if (is_object($r)) {
                        foreach ($r as $message) {
                            $action->getTarget()->addMessage($message);
                        }
                    }
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
