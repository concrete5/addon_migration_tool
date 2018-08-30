<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\Key;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\KeyObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PermissionKey implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $manager = \Core::make('migration/manager/import/permission/access_entity');
        $collection = new KeyObjectCollection();
        if ($element->permissionkeys->permissionkey) {
            foreach ($element->permissionkeys->permissionkey as $node) {
                $key = new Key();
                $key->setHandle((string) $node['handle']);
                $key->setName((string) $node['name']);
                $key->setPackage((string) $node['package']);
                $key->setCategory((string) $node['category']);
                if ((string) $node['can-trigger-workflow']) {
                    $key->setCanTriggerWorkflow(true);
                }
                if ((string) $node['has-custom-class']) {
                    $key->setHasCustomClass(true);
                }
                if (isset($node->access)) {
                    foreach ($node->access->children() as $ch) {
                        if ($ch->getName() == 'entity') {
                            $importer = $manager->driver((string) $ch['type']);
                            $entity = $importer->getEntity();
                            $entity->setEntityType((string) $ch['type']);
                            $importer->loadFromXml($entity, $ch);
                            $entity->setKey($key);
                            $key->getAccessEntities()->add($entity);
                        }
                    }
                }

                $collection->getKeys()->add($key);
                $key->setCollection($collection);
            }
        }

        return $collection;
    }
}
