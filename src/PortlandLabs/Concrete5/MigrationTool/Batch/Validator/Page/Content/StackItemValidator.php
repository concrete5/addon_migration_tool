<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class StackItemValidator implements ValidatorInterface
{
    public function itemExists(ItemInterface $item, Batch $batch)
    {
        if ($item->getReference()) {
            if (is_object($item->getContentObject())) {
                return true;
            }

            $stacks = $batch->getObjectCollection('stack');
            if ($stacks) {
                foreach ($stacks->getStacks() as $stack) {
                    if ($stack->getPath() && $stack->getPath() == $item->getReference()) {
                        return true;
                    }
                    if ($stack->getName() && $stack->getName() == $item->getReference()) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function addMissingItemMessage(ItemInterface $item, MessageCollection $messages)
    {
        if ($item->getReference()) {
            $messages->add(
                new \PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message(t('Referenced stack %s cannot be found in the site or in the current content batch.', $item->getReference()))
            );
        }
    }
}
