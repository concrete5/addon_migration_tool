<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Entity\Page\Feed;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageFeedsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $feeds = $batch->getObjectCollection('page_feed');

        if (!$feeds) {
            return;
        }

        foreach ($feeds->getFeeds() as $feed) {
            if (!$feed->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($feed);
                $f = new Feed();
                $parentID = intval($inspector->inspect($feed->getParent())->getReplacedValue());
                $pageType = intval($inspector->inspect($feed->getPageType())->getReplacedValue());
                $f->setTitle($feed->getTitle());
                $f->setHandle($feed->getHandle());
                $f->setDescription($feed->getDescription());
                $f->setParentID($parentID);
                $f->setPageTypeID($pageType);
                $f->setIncludeAllDescendents($feed->getIncludeAllDescendants());
                $f->setDisplayFeaturedOnly($feed->getDisplayFeaturedOnly());
                $f->setDisplayAliases($feed->getDisplayAliases());
                if ($feed->getContentType() == 'description') {
                    $f->displayShortDescriptionContent();
                } else {
                    $f->displayAreaContent($feed->getContentTypeArea());
                }
                $f->save();
                $logger->logPublishComplete($feed, $f);
            } else {
                $logger->logSkipped($feed);
            }
        }
    }
}
