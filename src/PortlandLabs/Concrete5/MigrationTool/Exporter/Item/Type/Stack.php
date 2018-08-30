<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Page\Stack\StackList;
use Concrete\Core\Support\Facade\StackFolder;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Stack extends AbstractType
{
    public function getHeaders()
    {
        return array(
            t('Type'),
            t('Path'),
            t('Name'),
        );
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('stacks');
        foreach ($collection->getItems() as $item) {
            $c = false;
            switch ($item->getStackType()) {
                case STACKS_PAGE_TYPE:
                    $c = \Concrete\Core\Page\Stack\Stack::getByID($item->getItemIdentifier());
                    break;
                case STACK_CATEGORY_PAGE_TYPE:
                    $c = StackFolder::getByID($item->getItemIdentifier());
                    break;
            }
            if (is_object($c)) {
                $this->exporter->export($c, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        switch ($exportItem->getStackType()) {
            case STACK_CATEGORY_PAGE_TYPE:
                $c = StackFolder::getByID($exportItem->getItemIdentifier());
                if (is_object($c)) {
                    $c = $c->getPage();
                }
                $type = t('Folder');
                break;
            default:
                $c = \Concrete\Core\Page\Stack\Stack::getByID($exportItem->getItemIdentifier());
                $type = t('Stack');
                break;
        }

        $path = substr($c->getCollectionPath(), strlen(STACKS_PAGE_PATH));

        return array(
            $type,
            $path,
            $c->getCollectionName(),
        );
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $page = false;
            $c = \Concrete\Core\Page\Stack\Stack::getByID($id);
            if (is_object($c) && !$c->isError()) {
                $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Stack();
                $page->setItemId($c->getCollectionID());
                $page->setStackType(STACKS_PAGE_TYPE);
            } else {
                $folder = StackFolder::getByID($id);
                if (is_object($folder)) {
                    $page = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Stack();
                    $page->setItemId($folder->getPage()->getCollectionID());
                    $page->setStackType(STACK_CATEGORY_PAGE_TYPE);
                }
            }
            if (is_object($page)) {
                $items[] = $page;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = new StackList();
        $stacks = $list->getResults();
        foreach ($stacks as $stack) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Stack();
            $item->setItemId($stack->getCollectionID());
            $item->setStackType($stack->getCollectionTypeHandle());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'stack';
    }

    public function getPluralDisplayName()
    {
        return t('Stacks');
    }
}
