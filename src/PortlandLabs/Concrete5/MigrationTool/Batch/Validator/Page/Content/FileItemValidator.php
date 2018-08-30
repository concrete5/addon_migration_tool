<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PictureItem;
use Concrete\Core\File\Service\Application;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;

defined('C5_EXECUTE') or die("Access Denied.");

class FileItemValidator implements ValidatorInterface
{
    public function itemExists(ItemInterface $item, Batch $batch)
    {
        return is_object($item->getContentObject());
    }

    /**
     * @param PictureItem $item
     * @param MessageCollection $messages
     */
    public function addMissingItemMessage(ItemInterface $item, MessageCollection $messages)
    {

        if ($item->getPrefix()) {
            $directoryService = new Application();
            $file = $directoryService->prefix($item->getPrefix(), $item->getFilename());
        } else {
            $file = $item->getFilename();
        }

        $messages->add(
            new Message(t('%s content item %s cannot be found', $item->getDisplayName(), $file), Message::E_WARNING)
        );
    }
}
