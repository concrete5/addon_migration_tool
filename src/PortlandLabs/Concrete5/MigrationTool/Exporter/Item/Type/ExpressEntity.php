<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Attribute\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntity extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        if ($exportItem->getItemIdentifier()) {
            $r = \Database::connection()->getEntityManager()->find(
                'Concrete\Core\Entity\Express\Entity', $exportItem->getItemIdentifier());
            if ($r) {
                return array($r->getEntityDisplayName());
            }
        }
        return [];
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('expressentities');
        foreach ($collection->getItems() as $expressEntity) {
            $entity = \Database::connection()->getEntityManager()->find(
                'Concrete\Core\Entity\Express\Entity', $expressEntity->getItemIdentifier());
            if (is_object($entity)) {
                $this->exporter->export($entity, $node);
            }
        }
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $item = \Database::connection()->getEntityManager()->find(
                'Concrete\Core\Entity\Express\Entity', $id);
            if (is_object($item)) {
                $entity = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExpressEntity();
                $entity->setItemId($item->getID());
                $items[] = $entity;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = \Database::connection()->getEntityManager()->getRepository(
            'Concrete\Core\Entity\Express\Entity'
        )->findAll();
        $items = array();
        foreach ($list as $entity) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExpressEntity();
            $item->setItemId($entity->getID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'express_entity';
    }

    public function getPluralDisplayName()
    {
        return t('Express Entities');
    }
}
