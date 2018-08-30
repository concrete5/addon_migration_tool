<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

use Concrete\Core\Support\Facade\Facade;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\ShortDescriptionTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\StandardAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value\StandardImporter;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * Class Attribute
 * This class is responsible for taking imported attribute values and transforming them based on their imported XML
 * into better data structures. This can't happen at import because we don't necessarily know the type of the attribute
 * being imported until after all the import is complete.
 */
abstract class Attribute implements TransformerInterface
{

    protected $manager;
    protected $entityManager;

    public function __construct()
    {
        $this->entityManager = \Database::connection()->getEntityManager();
        $this->manager = Facade::getFacadeApplication()->make('migration/manager/import/attribute/value');
    }

    public function getUntransformedEntityById($entityID)
    {
        $em = \Database::connection()->getEntityManager();
        return $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue')
            ->findOneById($entityID);
    }


    public function getUntransformedEntityObjects(TransformableEntityMapperInterface $mapper, BatchInterface $batch)
    {
        $results = array();
        foreach ($mapper->getTransformableEntityObjects($batch) as $object) {
            $value = $object->getAttributeValue();
            if ($value instanceof ImportedAttributeValue) {
                $results[] = $value;
            }
        }

        return $results;
    }

    public function getItem($attribute_value)
    {
        if ($attribute_value && $attribute_value->getAttribute()) {
            $handle = $attribute_value->getAttribute()->getHandle();
            $item = new Item($handle);

            return $item;
        }
    }

    abstract public function getDriver();

    /**
     * @param ImportedAttributeValue $entity
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
            $collection = $batch->getObjectCollection('attribute_key');
            if (is_object($collection)) {
                foreach ($collection->getKeys() as $key) {
                    if ($key->getHandle() == $item->getIdentifier()) {
                        $type = $key->getType();
                        break;
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
            $xml = simplexml_load_string($entity->getValue());
            $driver->import($xml, $entity);
        }
    }
}
