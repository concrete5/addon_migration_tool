<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ComposerOutputContent;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatePageTypesTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $target = $action->getTarget();
        if ($subject->getType()) {
            $mapper = new PageType();
            $targetItemList = new TargetItemList($target->getBatch(), $mapper);
            $item = new Item($subject->getType());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (!($targetItem instanceof IgnoredTargetItem)) {
                if ($targetItem instanceof UnmappedTargetItem) {
                    $action->getTarget()->addMessage(
                        new Message(t('Page Type <strong>%s</strong> does not exist.', $item->getIdentifier()))
                    );
                } else {
                    $targetPageType = Type::getByID($targetItem->getItemID());
                    if (is_object($targetPageType)) {
                        $composerMapper = new ComposerOutputContent();
                        $composerTargetItemList = new TargetItemList($target->getBatch(), $composerMapper);
                        $items = $composerMapper->getPageTypeComposerOutputContentItems($targetPageType);
                        foreach ($items as $item) {
                            $targetItem = $composerTargetItemList->getSelectedTargetItem($item);
                            if ($targetItem instanceof UnmappedTargetItem) {
                                $action->getTarget()->addMessage(
                                    new Message(t('Mapped page type %s contains unmapped composer output block in %s area.',
                                        $targetPageType->getPageTypeDisplayName(),
                                        $item->getBlock()->getAreaHandle()
                                    ))
                                );
                            }
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
