<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Permission\AccessEntity;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\UserAccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class UserImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new UserAccessEntity();
    }

    public function loadFromXml(AccessEntity $entity, \SimpleXMLElement $element)
    {
        $entity->setUserName((string) $element['name']);
    }
}
