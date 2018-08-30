<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTemplateItemValidator implements ValidatorInterface
{
    public function itemExists(ItemInterface $item, Batch $batch)
    {
        if (is_object($item->getContentObject())) {
            return true;
        }

        $mapper = new PageTemplate();
        $targetItemList = new TargetItemList($batch, $mapper);
        $importItem = new Item($item->getReference());
        $targetItem = $targetItemList->getSelectedTargetItem($importItem);
        if (!($targetItem instanceof UnmappedTargetItem)) {
            return true;
        }
    }

    public function addMissingItemMessage(ItemInterface $item, MessageCollection $messages)
    {
        $messages->add(
            new \PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message(t('Referenced page template %s cannot be found in the site or in the current content batch.', $item->getReference()))
        );
    }
}
