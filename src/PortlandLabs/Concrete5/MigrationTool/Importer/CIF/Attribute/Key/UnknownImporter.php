<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class UnknownImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new UnknownAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $key->setOptionsXml((string) $element->asXML());
    }
}
