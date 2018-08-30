<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\PageAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\StandardAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class PageImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new PageAttributeValue();
        $value->setValue((string) $node->value);
        return $value;
    }
}
