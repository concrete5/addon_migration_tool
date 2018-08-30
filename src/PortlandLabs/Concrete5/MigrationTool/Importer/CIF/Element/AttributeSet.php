<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeSetObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeSet implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new AttributeSetObjectCollection();
        if ($element->attributesets) {
            foreach ($element->attributesets->attributeset as $node) {
                $set = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeSet();
                $set->setHandle((string) $node['handle']);
                $set->setName((string) $node['name']);
                $set->setCategory((string) $node['category']);
                $set->setPackage((string) $node['package']);
                if (intval((string) $node['locked'])) {
                    $set->setIsLocked(true);
                }

                $attributes = array();
                if ($node->attributekey) {
                    foreach ($node->attributekey as $cn) {
                        $attributes[] = (string) $cn['handle'];
                    }
                }
                $set->setAttributes($attributes);
                $collection->getSets()->add($set);
                $set->setCollection($collection);
            }
        }

        return $collection;
    }
}
