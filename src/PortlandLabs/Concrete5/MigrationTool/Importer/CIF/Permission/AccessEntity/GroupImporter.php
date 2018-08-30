<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Permission\AccessEntity;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\GroupAccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new GroupAccessEntity();
    }

    public function loadFromXml(AccessEntity $entity, \SimpleXMLElement $element)
    {
        $entity->setGroupName((string) $element['name']);
    }
}
