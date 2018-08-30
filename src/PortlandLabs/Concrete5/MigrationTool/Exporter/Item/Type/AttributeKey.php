<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Key\Key;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKey extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('attributekeys');
        foreach ($collection->getItems() as $key) {
            $ak = Key::getInstanceByID($key->getItemIdentifier());
            if (is_object($ak)) {
                $this->exporter->export($ak, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $ak = Key::getInstanceByID($exportItem->getItemIdentifier());

        return array($ak->getAttributeKeyDisplayName());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $item = Key::getInstanceByID($id);
            if (is_object($item)) {
                $key = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeKey();
                $key->setItemId($item->getAttributeKeyID());
                $items[] = $key;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $category = Category::getByID($request->query->get('akCategoryID'));
        $items = array();
        if (is_object($category)) {
            $keys = Key::getAttributeKeyList($category->getAttributeKeyCategoryHandle());
            foreach ($keys as $key) {
                $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeKey();
                $item->setItemId($key->getAttributeKeyID());
                $items[] = $item;
            }
        }

        return $items;
    }

    public function getHandle()
    {
        return 'attribute_key';
    }

    public function getPluralDisplayName()
    {
        return t('Attribute Keys');
    }
}
