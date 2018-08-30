<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Block\BlockType\BlockTypeList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $bt = \Concrete\Core\Block\BlockType\BlockType::getByID($exportItem->getItemIdentifier());

        return array($bt->getBlockTypeName());
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('blocktypes');
        foreach ($collection->getItems() as $type) {
            $bt = \Concrete\Core\Block\BlockType\BlockType::getByID($type->getItemIdentifier());
            if (is_object($bt)) {
                $nodeType = $node->addChild('blocktype');
                $nodeType->addAttribute('handle', $bt->getBlockTypeHandle());
                $nodeType->addAttribute('package', $bt->getPackageHandle());
            }
        }
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $item = \Concrete\Core\Block\BlockType\BlockType::getByID($id);
            if (is_object($item)) {
                $blockType = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\BlockType();
                $blockType->setItemId($item->getBlockTypeID());
                $items[] = $blockType;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = new BlockTypeList();
        $list->sortByMultiple('btID asc');
        $list = $list->get();
        $items = array();
        foreach ($list as $type) {
            $blockType = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\BlockType();
            $blockType->setItemId($type->getBlockTypeID());
            $items[] = $blockType;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'block_type';
    }

    public function getPluralDisplayName()
    {
        return t('Block Types');
    }
}
