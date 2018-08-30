<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImageFileAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageFileImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new ImageFileAttributeValue();
        $value->setValue((string) $node->value->fID);

        return $value;
    }
}
