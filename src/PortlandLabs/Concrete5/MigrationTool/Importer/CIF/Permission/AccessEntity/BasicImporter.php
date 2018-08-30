<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Permission\AccessEntity;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class BasicImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new AccessEntity();
    }

    public function loadFromXml(AccessEntity $key, \SimpleXMLElement $element)
    {
        return false;
    }
}
