<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\User\Group\Group;
use Concrete\Core\User\Group\GroupList;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class UserGroup implements MapperInterface
{

    protected $groups = array();

    public function getMappedItemPluralName()
    {
        return t('User Groups');
    }

    public function getHandle()
    {
        return 'user_group';
    }

    public function getItems(BatchInterface $batch)
    {
        $groups = array();
        $users = $batch->getObjectCollection('user');
        if (is_object($users)) {
            foreach($users->getUsers() as $user) {
                foreach ($user->getGroups() as $group) {
                    if ($group->getPath() && !in_array($group->getPath(), $groups)) {
                        $groups[] = $group->getPath();
                    }
                    if ($group->getName() && !in_array('/' . $group->getName(), $groups)) {
                        $groups[] = '/' . $group->getName();
                    }
                }
            }
        }

        $items = array();
        foreach ($groups as $group) {
            $item = new Item();
            $item->setIdentifier($group);
            $items[] = $item;
        }

        return $items;
    }


    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        $group = Group::getByPath($item->getIdentifier());
        if (is_object($group)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($group->getGroupPath());
            $targetItem->setItemName($group->getGroupDisplayName());

            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('group');
            if (is_object($collection)) {
                foreach ($collection->getGroups() as $group) {
                    if ($group->getPath()) {
                        $identifier = $group->getPath();
                    } else {
                        $identifier = '/' . $group->getName();
                    }
                    if ($identifier == $item->getIdentifier()) {
                        $targetItem = new TargetItem($this);
                        $targetItem->setItemId($identifier);
                        $targetItem->setItemName($group->getName());
                        return $targetItem;
                    }
                }
            }
        }
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        $collection = $batch->getObjectCollection('group');
        $items = array();
        if ($collection) {
            foreach ($collection->getGroups() as $group) {
                if (!$group->getPublisherValidator()->skipItem()) {
                    $item = new TargetItem($this);
                    if ($group->getPath()) {
                        $identifier = $group->getPath();
                    } else {
                        $identifier = '/' . $group->getName();
                    }
                    $item->setItemId($identifier);
                    $item->setItemName($group->getName());
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
        $cache = \Core::make('cache/request');
        $item = $cache->getItem(sprintf('migration/mapper/group/target_items/%s', $batch->getID()));
        if (!$item->isMiss()) {
            $items = $item->get();
        } else {
            $list = new GroupList();
            $groups = $list->getResults();
            foreach($groups as $group) {
                $targetItem = new TargetItem($this);
                $targetItem->setItemId($group->getGroupPath());
                $targetItem->setItemName($group->getGroupDisplayName());
                $items[] = $targetItem;
            }
            usort($items, function($a, $b) {
                return strcasecmp($a->getItemName(), $b->getItemName());
            });
            $cache->save($item->set($items));
        }
        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return Group::getByPath($targetItem->getItemID());
    }
}
