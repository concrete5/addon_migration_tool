<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type;

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

class PageAttribute extends Attribute
{

    protected function getPageAttribute(ImportedAttributeValue $entity)
    {
        $attribute = $entity->getAttribute();
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute');

        return $r->findOneByAttribute($attribute);
    }

    public function getDriver()
    {
        return 'page_attribute';
    }

    /**
     * @param ImportedAttributeValue $entity
     * @param MapperInterface $mapper
     * @param ItemInterface $item
     * @param TargetItem $targetItem
     * @param BatchInterface $batch
     */
    public function transform($entity, MapperInterface $mapper, ItemInterface $item, TargetItem $targetItem, BatchInterface $batch)
    {
        if ($targetItem instanceof ShortDescriptionTargetItem) {
            $driver = new StandardImporter();
        } else {
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
        }

        if (isset($type)) {
            try {
                $driver = $this->manager->driver($type);
            } catch (\Exception $e) {
            }
        }

        if (isset($driver)) {
            $xml = simplexml_load_string($entity->getValue());
            if ($targetItem instanceof ShortDescriptionTargetItem) {
                /**
                 * @var StandardAttributeValue
                 */
                $value = $driver->parse($xml);
                $pageAttribute = $this->getPageAttribute($entity);
                if (is_object($pageAttribute)) {
                    $page = $pageAttribute->getPage();
                    /*
                     * @var $page Page
                     */
                    $page->setDescription($value->getValue());
                    $this->entityManager->persist($page);
                    $this->entityManager->remove($pageAttribute);
                    $this->entityManager->flush();
                }
            } else {
                $driver->import($xml, $entity);
            }
        }
    }
}
