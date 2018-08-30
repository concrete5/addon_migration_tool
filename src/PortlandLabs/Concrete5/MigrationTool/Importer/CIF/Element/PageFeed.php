<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageFeed as CorePageFeed;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageFeedObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageFeed implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new PageFeedObjectCollection();
        if ($element->pagefeeds->feed) {
            foreach ($element->pagefeeds->feed as $node) {
                $feed = new CorePageFeed();
                $feed->setHandle((string) $node->handle);
                $feed->setTitle((string) $node->title);
                $feed->setParent((string) $node->parent);
                $feed->setDescription((string) $node->description);
                $feed->setPageType((string) $node->pagetype);
                if (intval((string) $node->aliases)) {
                    $feed->setDisplayAliases(true);
                }
                if (intval((string) $node->descendents)) {
                    $feed->setIncludeAllDescendants(true);
                }
                if (intval((string) $node->featured)) {
                    $feed->setDisplayFeaturedOnly(true);
                }
                $contentType = $node->contenttype;
                $type = (string) $contentType['type'];
                if ($type == 'description') {
                    $feed->setContentType('description');
                } elseif ($type == 'area') {
                    $feed->setContentType('area');
                    $feed->setContentTypeArea((string) $contentType['handle']);
                }
                $collection->getFeeds()->add($feed);
                $feed->setCollection($collection);
            }
        }

        return $collection;
    }
}
