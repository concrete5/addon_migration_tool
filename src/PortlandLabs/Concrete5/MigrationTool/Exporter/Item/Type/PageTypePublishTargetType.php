<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Page\Type\PublishTarget\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypePublishTargetType extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('pagetypepublishtargettypes');
        foreach ($collection->getItems() as $type) {
            $t = Type::getByID($type->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = Type::getByID($exportItem->getItemIdentifier());
        $return = array();
        if (is_object($t)) {
            $return[] = $t->getPageTypePublishTargetTypeName();
        }

        return $return;
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = Type::getByID($id);
            if (is_object($t)) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\PageTypePublishTargetType();
                $type->setItemId($t->getPageTypePublishTargetTypeID());
                $items[] = $type;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = Type::getList();
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\PageTypePublishTargetType();
            $item->setItemId($t->getPageTypePublishTargetTypeID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'page_type_publish_target_type';
    }

    public function getPluralDisplayName()
    {
        return t('Page Type Publish Target Types');
    }
}
