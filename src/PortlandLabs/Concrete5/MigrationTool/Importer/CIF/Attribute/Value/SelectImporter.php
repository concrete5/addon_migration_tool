<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SelectAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new SelectAttributeValue();
        $options = array();
        if ($node->value->option) {
            foreach ($node->value->option as $option) {
                $options[] = (string) $option;
            }
        }
        $value->setValue($options);

        return $value;
    }
}
