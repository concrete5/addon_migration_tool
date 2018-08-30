<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\NumberAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class NumberImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new NumberAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        return false;
    }
}
