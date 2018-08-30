<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Page\PageList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Page extends SinglePage
{
    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('pages');
        foreach ($collection->getItems() as $page) {
            $c = \Page::getByID($page->getItemIdentifier());
            if (is_object($c) && !$c->isError()) {
                $this->exporter->export($c, $node);
            }
        }
    }

    public function getResults(Request $request)
    {
        $pl = new PageList();
        $site = \Core::make('site')->getActiveSiteForEditing();
        $pl->setSiteTreeObject($site->getSiteTreeObject());
        $pl->includeSystemPages();
        $query = $request->query->all();

        $keywords = $query['keywords'];
        $ptID = $query['ptID'];
        $startingPoint = intval($query['startingPoint']);
        $datetime = \Core::make('helper/form/date_time')->translate('datetime', $query);
        $pl->ignorePermissions();
        if ($startingPoint) {
            $parent = \Page::getByID($startingPoint, 'ACTIVE');
            $pl->filterByPath($parent->getCollectionPath());
        }
        if ($datetime) {
            $pl->filterByPublicDate($datetime, '>=');
        }

        if ($ptID) {
            $pl->filterByPageTypeID($ptID);
        }
        if ($keywords) {
            $pl->filterByKeywords($keywords);
        }
        $pl->setItemsPerPage(1000);
        $results = $pl->getResults();
        $items = array();
        foreach ($results as $c) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Page();
            $item->setItemId($c->getCollectionID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'page';
    }

    public function getPluralDisplayName()
    {
        return t('Pages');
    }
}
