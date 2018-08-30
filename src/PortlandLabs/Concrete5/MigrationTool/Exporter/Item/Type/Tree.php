<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Tree extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Tree Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('trees');
        foreach ($collection->getItems() as $tree) {
            $t = \Concrete\Core\Tree\Tree::getByID($tree->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = \Concrete\Core\Tree\Tree::getByID($exportItem->getItemIdentifier());

        return array($t->getTreeDisplayName());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = \Concrete\Core\Tree\Tree::getByID($id);
            if (is_object($t)) {
                $tree = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Tree();
                $tree->setItemId($t->getTreeID());
                $items[] = $tree;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $trees = array();
        $db = \Database::connection();
        $r = $db->Execute('select treeID from Trees order by treeID asc');
        while ($row = $r->FetchRow()) {
            $tree = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Tree();
            $tree->setItemId($row['treeID']);
            $trees[] = $tree;
        }

        return $trees;
    }

    public function getHandle()
    {
        return 'tree';
    }

    public function getPluralDisplayName()
    {
        return t('Trees');
    }
}
