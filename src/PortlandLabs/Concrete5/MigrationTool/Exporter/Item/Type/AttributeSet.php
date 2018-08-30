<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Set;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeSet extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $set = Set::getByID($exportItem->getItemIdentifier());
        return array($set->getAttributeSetName());
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('attributesets');
        foreach ($collection->getItems() as $item) {
            $set = Set::getByID($item->getItemIdentifier());
            if (is_object($set)) {
                $this->exporter->export($set, $node);
            }
        }
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $item = Set::getByID($id);
            if (is_object($item)) {
                $set = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeSet();
                $set->setItemId($item->getAttributeSetID());
                $items[] = $set;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $category = Category::getByID($request->query->get('akCategoryID'));
        $items = array();
        if (is_object($category)) {
            $sets = $category->getController()->getSetManager()->getAttributeSets();
            foreach ($sets as $set) {
                $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeSet();
                $item->setItemId($set->getAttributeSetID());
                $items[] = $item;
            }
        }

        return $items;
    }

    public function getHandle()
    {
        return 'attribute_set';
    }

    public function getPluralDisplayName()
    {
        return t('Attribute Sets');
    }
}
