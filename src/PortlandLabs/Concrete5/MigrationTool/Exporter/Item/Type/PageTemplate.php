<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTemplate extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('pagetemplates');
        foreach ($collection->getItems() as $template) {
            $t = \Concrete\Core\Page\Template::getByID($template->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = \Concrete\Core\Page\Template::getByID($exportItem->getItemIdentifier());

        return array($t->getPageTemplateDisplayName());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = \Concrete\Core\Page\Template::getByID($id);
            if (is_object($t)) {
                $template = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\PageTemplate();
                $template->setItemId($t->getPageTemplateID());
                $items[] = $template;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = \Concrete\Core\Page\Template::getList();
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\PageTemplate();
            $item->setItemId($t->getPageTemplateID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'page_template';
    }

    public function getPluralDisplayName()
    {
        return t('Page Templates');
    }
}
