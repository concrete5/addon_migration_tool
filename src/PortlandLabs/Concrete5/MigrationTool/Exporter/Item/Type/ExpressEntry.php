<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Attribute\Type;
use Concrete\Core\Express\EntryList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntry extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Entry'));
    }

    public function getResultColumns(ExportItem $exportItem)
    {

        $entry = \Express::getEntry($exportItem->getItemIdentifier());

        return array(
            $entry->getLabel()
        );
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('expressentries');
        foreach ($collection->getItems() as $expressEntry) {
            $entry = \Express::getEntry($expressEntry->getItemIdentifier());
            if (is_object($entry)) {
                $this->exporter->export($entry, $node);
            }
        }
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $entry = \Express::getEntry($id);
            if (is_object($entry)) {
                $entity = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExpressEntry();
                $entity->setItemId($id);
                $items[] = $entity;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $em = \Database::get()->getEntityManager();
        $entity = $em->find('Concrete\Core\Entity\Express\Entity', $request->query->get('id'));
        $list = new EntryList($entity);
        $items = array();
        foreach ($list->getResults() as $entry) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExpressEntry();
            $item->setItemId($entry->getID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'express_entry';
    }

    public function getPluralDisplayName()
    {
        return t('Express Entries');
    }
}
