<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Attribute\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeType extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $at = Type::getByID($exportItem->getItemIdentifier());

        return array($at->getAttributeTypeName());
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('attributetypes');
        foreach ($collection->getItems() as $type) {
            $at = Type::getByID($type->getItemIdentifier());
            if (is_object($at)) {
                $this->exporter->export($at, $node);
            }
        }
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $item = Type::getByID($id);
            if (is_object($item)) {
                $attributeType = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeType();
                $attributeType->setItemId($item->getAttributeTypeID());
                $items[] = $attributeType;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = Type::getAttributeTypeList();
        $items = array();
        foreach ($list as $type) {
            $attributeType = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\AttributeType();
            $attributeType->setItemId($type->getAttributeTypeID());
            $items[] = $attributeType;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'attribute_type';
    }

    public function getPluralDisplayName()
    {
        return t('Attribute Types');
    }
}
