<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\User\UserInfo;
use Concrete\Core\User\UserList;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Provider\UserProviderInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class User implements MapperInterface
{
    public function getMappedItemPluralName()
    {
        return t('Users');
    }

    public function getHandle()
    {
        return 'user';
    }

    public function getItems(BatchInterface $batch)
    {
        $users = array();
        $collections = $batch->getObjectCollections();
        foreach($collections as $collection) {
            if ($collection instanceof UserProviderInterface) {
                foreach($collection->getUserNames() as $user) {
                    if (!in_array($user, $users)) {
                        $users[] = $user;
                    }
                }
            }
        }

        $items = array();
        foreach ($users as $user) {
            $item = new Item();
            $item->setIdentifier($user);
            $items[] = $item;
        }

        return $items;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        $user = UserInfo::getByUserName($item->getIdentifier());
        if (is_object($user)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($user->getUserName());
            $targetItem->setItemName($user->getUserDisplayName());

            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('user');
            if (is_object($collection)) {
                foreach ($collection->getUsers() as $user) {
                    if ($user->getName() == $item->getIdentifier()) {
                        $targetItem = new TargetItem($this);
                        $targetItem->setItemId($user->getName());
                        $targetItem->setItemName($user->getName());
                        return $targetItem;
                    }
                }
            }
        }
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        $collection = $batch->getObjectCollection('user');
        $items = array();
        if ($collection) {
            foreach ($collection->getUsers() as $user) {
                if (!$user->getPublisherValidator()->skipItem()) {
                    $item = new TargetItem($this);
                    $item->setItemId($user->getName());
                    $item->setItemName($user->getName());
                    $items[] = $item;
                }
            }
        }

        return $items;
    }

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $ul = new UserList();
        $ul->sortByUserName();
        $users = $ul->getResults();
        $items = array();
        foreach ($users as $user) {
            $item = new TargetItem($this);
            $item->setItemId($user->getUserName());
            $item->setItemName($user->getUserDisplayName());
            $items[] = $item;
        }

        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return \UserInfo::getByUserName($targetItem->getItemID());
    }
}
