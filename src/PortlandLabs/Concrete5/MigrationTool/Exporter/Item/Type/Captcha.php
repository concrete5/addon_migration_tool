<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Captcha\Library;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Captcha extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('systemcaptcha');
        foreach ($collection->getItems() as $type) {
            $captcha = Library::getByHandle($type->getItemIdentifier());
            if (is_object($captcha)) {
                $this->exporter->export($captcha, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = Library::getByHandle($exportItem->getItemIdentifier());
        $return = array();
        if (is_object($t)) {
            $return[] = $t->getSystemCaptchaLibraryName();
        }

        return $return;
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = Library::getByHandle($id);
            if (is_object($t)) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\CaptchaLibrary();
                $type->setHandle($t->getSystemCaptchaLibraryHandle());
                $items[] = $type;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = Library::getList();
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\CaptchaLibrary();
            $item->setHandle($t->getSystemCaptchaLibraryHandle());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'captcha';
    }

    public function getPluralDisplayName()
    {
        return t('Captcha Libraries');
    }
}
