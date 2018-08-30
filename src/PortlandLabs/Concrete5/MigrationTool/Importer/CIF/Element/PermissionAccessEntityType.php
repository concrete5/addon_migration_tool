<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntityType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntityTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PermissionAccessEntityType implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new AccessEntityTypeObjectCollection();
        if ($element->permissionaccessentitytypes->permissionaccessentitytype) {
            foreach ($element->permissionaccessentitytypes->permissionaccessentitytype as $node) {
                $type = new AccessEntityType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setPackage((string) $node['package']);
                $categories = array();
                if ($node->categories->category) {
                    foreach ($node->categories->category as $cn) {
                        $categories[] = (string) $cn['handle'];
                    }
                }
                $type->setCategories($categories);
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }

        return $collection;
    }
}
