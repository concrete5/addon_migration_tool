<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFeedItemValidator implements ValidatorInterface
{
    public function itemExists(ItemInterface $item, Batch $batch)
    {
        if (is_object($item->getContentObject())) {
            return true;
        }

        $feeds = $batch->getObjectCollection('page_feed');
        foreach ($feeds->getFeeds() as $feed) {
            if ($feed->getHandle() == $item->getReference()) {
                return true;
            }
        }

        return false;
    }

    public function addMissingItemMessage(ItemInterface $item, MessageCollection $messages)
    {
        $messages->add(
            new Message(t('Referenced page feed %s cannot be found in the site or in the current content batch.', $item->getReference()))
        );
    }
}
