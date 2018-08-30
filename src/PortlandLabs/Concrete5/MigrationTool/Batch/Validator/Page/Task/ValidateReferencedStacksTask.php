<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\StackItem;
use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\StackItemValidator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StackDisplayBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateReferencedStacksTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        $blocks = $action->getSubject();
        $target = $action->getTarget();
        foreach ($blocks as $block) {
            if ($block->getType() == 'core_stack_display') {
                $value = $block->getBlockValue();
                if ($value instanceof StackDisplayBlockValue) {
                    $stack = $value->getStackPath();
                    $validator = new StackItemValidator();
                    $item = new StackItem($stack);
                    if (!$validator->itemExists($item, $target->getBatch())) {
                        $validator->addMissingItemMessage($item, $action->getTarget()->getMessages());
                    }
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
