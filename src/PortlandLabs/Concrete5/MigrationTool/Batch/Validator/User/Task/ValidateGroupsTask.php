<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\User\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\UserGroup;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateGroupsTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $userMapper = new UserGroup();
        $targetItemList = new TargetItemList($target->getBatch(), $userMapper);
        foreach ($subject->getGroups() as $group) {
            if ($group->getPath()) {
                $item = new Item($group->getPath());
            } else {
                $item = new Item('/' . $group->getName());
            }
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $action->getTarget()->addMessage(
                    new Message(t('Group <strong>%s</strong> does not exist.', $item->getIdentifier()))
                );
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
