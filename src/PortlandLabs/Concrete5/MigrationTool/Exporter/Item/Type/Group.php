<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Concrete\Core\User\Group\GroupList;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Group extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('groups');
        foreach ($collection->getItems() as $group) {
            $g = \Concrete\Core\User\Group\Group::getByID($group->getItemIdentifier());
            if (is_object($g)) {
                $this->exporter->export($g, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $g = \Concrete\Core\User\Group\Group::getByID($exportItem->getItemIdentifier());

        return array($g->getGroupDisplayName());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $g = \Concrete\Core\User\Group\Group::getByID($id);
            if (is_object($g)) {
                $group = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Group();
                $group->setItemId($g->getGroupID());
                $items[] = $group;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = new GroupList();
        $items = array();
        foreach ($list->getResults() as $g) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Group();
            $item->setItemId($g->getGroupID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'group';
    }

    public function getPluralDisplayName()
    {
        return t('Groups');
    }
}
