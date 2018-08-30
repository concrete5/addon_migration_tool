<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAttribute;

class ExpressAttribute extends Attribute
{

    public function getDriver()
    {
        return 'express_attribute';
    }

    public function getItem($entryAttribute)
    {
        if ($entryAttribute && $entryAttribute->getAttribute()) {
            $handle = $entryAttribute->getAttribute()->getHandle();
            $entity = $entryAttribute->getEntry()->getEntity();
            $item = new Item($entity . '|' . $handle);
            return $item;
        }
    }

    public function getUntransformedEntityById($entityID)
    {
        $em = \Database::connection()->getEntityManager();
        return $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAttribute')
            ->findOneById($entityID);
    }

    public function getUntransformedEntityObjects(TransformableEntityMapperInterface $mapper, BatchInterface $batch)
    {
        $results = array();
        foreach ($mapper->getTransformableEntityObjects($batch) as $object) {
            $attribute = $object->getAttribute();
            $value = $attribute->getAttributeValue();
            if ($value instanceof ImportedAttributeValue) {
                $results[] = $object;
            }
        }

        return $results;
    }

    /**
     * @param EntryAttribute $entity
     * @param MapperInterface $mapper
     * @param ItemInterface $item
     * @param TargetItem $targetItem
     * @param BatchInterface $batch
     */
    public function transform($entity, MapperInterface $mapper, ItemInterface $item, TargetItem $targetItem, BatchInterface $batch)
    {
        $ak = $mapper->getTargetItemContentObject($targetItem);
        if (is_object($ak)) {
            $type = $ak->getAttributeType()->getAttributeTypeHandle();
        } else {
            list($entityHandle, $attributeHandle) = explode('|', $item->getIdentifier());
            $collection = $batch->getObjectCollection('express_entity');
            if (is_object($collection)) {
                foreach ($collection->getEntities() as $expressEntity) {
                    if ($expressEntity->getHandle() == $entityHandle) {
                        $attributeCollection = $expressEntity->getAttributeKeys();
                        if ($attributeCollection) {
                            $attributes = $attributeCollection->getKeys();
                            foreach($attributes as $attribute) {
                                if ($attribute->getHandle() == $attributeHandle) {
                                    $type = $attribute->getType();
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (isset($type)) {
            try {
                $driver = $this->manager->driver($type);
            } catch (\Exception $e) {
            }
        }

        if (isset($driver)) {
            $entity = $entity->getAttribute()->getAttributeValue();
            $xml = simplexml_load_string($entity->getValue());
            $driver->import($xml, $entity);
        }
    }



}
