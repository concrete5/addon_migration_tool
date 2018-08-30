<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\GroupObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Group implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new GroupObjectCollection();
        if ($element->groups->group) {
            foreach ($element->groups->group as $node) {
                $group = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Group();
                $group->setPath((string) $node['path']);
                $group->setName((string) $node['name']);
                $group->setDescription((string) $node['description']);
                $group->setPackage((string) $node['package']);
                $collection->getGroups()->add($group);
                $group->setCollection($collection);
            }
        }

        return $collection;
    }
}
