<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateReferencedContentItemsTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        $blocks = $action->getSubject();
        $target = $action->getTarget();
        foreach ($blocks as $block) {
            $value = $block->getBlockValue();
            if (is_object($value)) {
                $inspector = $value->getInspector();
                $items = $inspector->getMatchedItems($target->getBatch());
                foreach ($items as $item) {
                    $validatorFactory = new Factory($item);
                    $validator = $validatorFactory->getValidator();
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
