<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Permission\AccessEntity;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

interface ImporterInterface
{
    public function getEntity();
    public function loadFromXml(AccessEntity $entity, \SimpleXMLElement $element);
}
