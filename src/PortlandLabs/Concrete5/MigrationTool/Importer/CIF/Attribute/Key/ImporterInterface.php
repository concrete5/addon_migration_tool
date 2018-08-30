<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

interface ImporterInterface
{
    public function getEntity();
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element);
}
