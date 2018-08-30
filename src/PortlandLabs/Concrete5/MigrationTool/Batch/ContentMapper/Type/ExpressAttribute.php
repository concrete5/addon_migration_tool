<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Attribute\Category\ExpressCategory;
use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\ShortDescriptionTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CollectionAttributeComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressAttribute extends Attribute
{

    public function getAttributeKeyCategoryHandle()
    {
        return 'express';
    }

    public function getMappedItemPluralName()
    {
        return t('Express Attributes');
    }

    public function getHandle()
    {
        return 'express_attribute';
    }

    protected function getEntries(BatchInterface $batch)
    {
        $entries = $batch->getObjectCollection('express_entry');
        if (is_object($entries)) {
            return $entries->getEntries();
        }
        return [];
    }

    public function getTransformableEntityObjects(BatchInterface $batch)
    {
        $attributes = [];
        foreach($this->getEntries($batch) as $entry) {
            foreach ($entry->getAttributes() as $attribute) {
                if (is_object($attribute->getAttribute())) {
                    $attributes[] = $attribute;
                }
            }
        }

        return $attributes;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        list($entityHandle, $attributeHandle) = explode('|', $item->getIdentifier());
        $ak = null;
        $expressObject = \Express::getObjectByHandle($entityHandle);
        if ($expressObject) {
            $controller = $expressObject->getAttributeKeyCategory();
            $ak = $controller->getAttributeKeyByHandle($attributeHandle);
        }

        if (is_object($ak)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($ak->getAttributeKeyHandle());
            $targetItem->setItemName($ak->getAttributeKeyDisplayName());
            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('express_entity');
            if (is_object($collection)) {
                foreach ($collection->getEntities() as $entity) {
                    if ($entity->getHandle() == $entityHandle) {
                        $attributeCollection = $entity->getAttributeKeys();
                        if ($attributeCollection) {
                            $attributes = $attributeCollection->getKeys();
                            foreach($attributes as $attribute) {
                                if ($attribute->getHandle() == $attributeHandle) {
                                    $targetItem = new TargetItem($this);
                                    $targetItem->setItemId($entityHandle . '|' . $attributeHandle);
                                    $targetItem->setItemName($attributeHandle);
                                    return $targetItem;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $entities = \Express::getEntities();
        $items = array();
        foreach($entities as $entity) {
            $category = $entity->getAttributeKeyCategory();
            $keys = $category->getList();
            usort($keys, function ($a, $b) {
                return strcasecmp($a->getAttributeKeyName(), $b->getAttributeKeyName());
            });
            foreach ($keys as $ak) {
                $item = new TargetItem($this);
                $item->setItemId($ak->getAttributeKeyHandle());
                $item->setItemName($ak->getAttributeKeyDisplayName());
                $items[] = $item;
            }
        }

        return $items;
    }


    public function getItems(BatchInterface $batch)
    {
        $identifiers = array();
        foreach($this->getEntries($batch) as $entry) {
            foreach ($entry->getAttributes() as $attribute) {
                if (is_object($attribute->getAttribute())) {
                    $identifier = $entry->getEntity() . '|' . $attribute->getAttribute()->getHandle();
                    if (!in_array($identifier, $identifiers)) {
                        $identifiers[] = $identifier;
                    }
                }
            }

        }

        $items = array();
        foreach ($identifiers as $handle) {
            $item = new Item();
            $item->setIdentifier($handle);
            $items[] = $item;
        }
        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        $targetAttributeKeyHandle = $targetItem->getItemID();
        list($entityHandle, $sourceAttributeHandle) = explode('|', $targetItem->getSourceItemIdentifier());
        $identifier = sprintf('migration/attribute_key/express/%s/%s', $entityHandle , $targetAttributeKeyHandle);
        $item = $this->cache->getItem($identifier);
        if (!$item->isMiss()) {
            return $item->get();
        }

        $item->lock();
        $key = null;
        $expressObject = \Express::getObjectByHandle($entityHandle);
        if ($expressObject) {
            $controller = $expressObject->getAttributeKeyCategory();
            $key = $controller->getAttributeKeyByHandle($targetAttributeKeyHandle);
        }

        $this->cache->save($item->set($key));

        return $key;

    }



}
