<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKeyCategory implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $collection = new AttributeKeyCategoryObjectCollection();
        if ($element->attributecategories->category) {
            foreach ($element->attributecategories->category as $node) {
                $category = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategory();
                $category->setHandle((string) $node['handle']);
                $category->setAllowSets((string) $node['allow-sets']);
                $category->setPackage((string) $node['package']);
                $collection->getCategories()->add($category);
                $category->setCollection($collection);
            }
        }

        return $collection;
    }
}
