<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\Category;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\CategoryObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PermissionKeyCategory implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new CategoryObjectCollection();
        if ($element->permissioncategories->category) {
            foreach ($element->permissioncategories->category as $node) {
                $category = new Category();
                $category->setHandle((string) $node['handle']);
                $category->setPackage((string) $node['package']);
                $collection->getCategories()->add($category);
                $category->setCollection($collection);
            }
        }

        return $collection;
    }
}
