<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class Importer extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new ImportedAttributeValue();
        $value->setValue((string) $node->asXML());

        return $value;
    }
}
