<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Theme extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('themes');
        foreach ($collection->getItems() as $theme) {
            $t = \Concrete\Core\Page\Theme\Theme::getByID($theme->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = \Concrete\Core\Page\Theme\Theme::getByID($exportItem->getItemIdentifier());

        return array($t->getThemeName());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = \Concrete\Core\Page\Theme\Theme::getByID($id);
            if (is_object($t)) {
                $theme = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Theme();
                $theme->setItemId($t->getThemeID());
                $items[] = $theme;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = \Concrete\Core\Page\Theme\Theme::getList();
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Theme();
            $item->setItemId($t->getThemeID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'theme';
    }

    public function getPluralDisplayName()
    {
        return t('Themes');
    }
}
