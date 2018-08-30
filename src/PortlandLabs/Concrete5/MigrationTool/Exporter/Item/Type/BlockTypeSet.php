<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Block\BlockType\Set;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockTypeSet extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $set = Set::getByID($exportItem->getItemIdentifier());
        return array($set->getBlockTypeSetName());
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('blocktypesets');
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
                $blockTypeSet = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\BlockTypeSet();
                $blockTypeSet->setItemId($item->getBlockTypeSetID());
                $items[] = $blockTypeSet;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = Set::getList();
        $items = array();
        foreach ($list as $set) {
            $blockTypeSet = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\BlockTypeSet();
            $blockTypeSet->setItemId($set->getBlockTypeSetID());
            $items[] = $blockTypeSet;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'block_type_set';
    }

    public function getPluralDisplayName()
    {
        return t('Block Type Sets');
    }
}
