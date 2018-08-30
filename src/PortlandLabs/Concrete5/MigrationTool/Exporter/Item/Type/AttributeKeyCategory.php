<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Attribute\Key\Category;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKeyCategory extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('attributecategories');
        foreach ($collection->getItems() as $category) {
            $category = Category::getByID($category->getItemIdentifier());
            if (is_object($category)) {
                $cat = $node->addChild('category');
                $cat->addAttribute('handle', $category->getAttributeKeyCategoryHandle());
                $cat->addAttribute('allow-sets', $category->allowAttributeSets());
                $cat->addAttribute('package', $category->getPackageHandle());
                $attributeTypes = $category->getAttributeTypes();
                if (!$attributeTypes->isEmpty()) {
                    $xTypes = $cat->addChild('attributetypes');
                    foreach ($attributeTypes as $attributeType) {
                        $xType = $xTypes->addChild('attributetype');
                        $xType->addAttribute('handle', $attributeType->getAttributeTypeHandle());
                    }
                }
                
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = Category::getByID($exportItem->getItemIdentifier());

        return array($t->getAttributeKeyCategoryHandle());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = Category::getByID($id);
            if (is_object($t)) {
                $category = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeKeyCategory();
                $category->setItemId($t->getAttributeKeyCategoryID());
                $items[] = $category;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = Category::getList();
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeKeyCategory();
            $item->setItemId($t->getAttributeKeyCategoryID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'attribute_key_category';
    }

    public function getPluralDisplayName()
    {
        return t('Attribute Categories');
    }
}
