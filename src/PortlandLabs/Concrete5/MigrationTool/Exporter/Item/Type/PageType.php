<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class PageType extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('pagetypes');
        foreach ($collection->getItems() as $type) {
            $t = \Concrete\Core\Page\Type\Type::getByID($type->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = \Concrete\Core\Page\Type\Type::getByID($exportItem->getItemIdentifier());
        if (is_object($t)) {
            if (method_exists($t, 'getSiteTypeObject')) {
                $siteType = $t->getSiteTypeObject();
                if (!$siteType->isDefault()) {
                    return array($siteType->getSiteTypeName() . ': ' . $t->getPageTypeDisplayName());
                }
            }

            return array($t->getPageTypeDisplayName());
        }

        return array();
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = \Concrete\Core\Page\Type\Type::getByID($id);
            if (is_object($t)) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\PageType();
                $type->setItemId($t->getPageTypeID());
                $items[] = $type;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = \Concrete\Core\Page\Type\Type::getList(true);
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\PageType();
            $item->setItemId($t->getPageTypeID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'page_type';
    }

    public function getPluralDisplayName()
    {
        return t('Page Types');
    }
}
