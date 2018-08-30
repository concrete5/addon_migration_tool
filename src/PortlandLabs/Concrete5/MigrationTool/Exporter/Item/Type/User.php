<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\User\Group\Group as CoreGroup;
use Concrete\Core\User\UserInfo;
use Concrete\Core\User\UserList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class User extends AbstractType
{
    public function getHeaders()
    {
        return array(
            t('Name'),
            t('Email'),
        );
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('users');
        foreach ($collection->getItems() as $user) {
            $ui = UserInfo::getByID($user->getItemIdentifier());
            if ($ui) {
                $this->exporter->export($ui, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $ui = UserInfo::getByID($exportItem->getItemIdentifier());

        return array(
            $ui->getUserDisplayName(),
            $ui->getUserEmail(),
        );
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $ui = UserInfo::getByID($id);
            if (is_object($ui)) {
                $user = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\User();
                $user->setItemId($ui->getUserID());
                $items[] = $user;
            }
        }

        return $items;
    }


    public function getResults(Request $request)
    {
        $list = new UserList();
        $query = $request->query->all();

        $keywords = $query['keywords'];
        $gID = $query['gID'];
        $datetime = \Core::make('helper/form/date_time')->translate('datetime', $query);

        if ($datetime) {
            $list->filterByDateAdded($datetime, '>=');
        }

        if ($gID) {
            $list->filterByGroup(CoreGroup::getByID($gID));
        }
        if ($keywords) {
            $list->filterByKeywords($keywords);
        }
        $list->setItemsPerPage(1000);
        $results = $list->getResults();
        $items = array();
        foreach ($results as $user) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\User();
            $item->setItemId($user->getUserID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'user';
    }

    public function getPluralDisplayName()
    {
        return t('Users');
    }
}
