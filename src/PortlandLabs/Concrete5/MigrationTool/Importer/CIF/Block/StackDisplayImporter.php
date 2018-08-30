<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StackDisplayBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class StackDisplayImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new StackDisplayBlockValue();
        $stack = (string) $node->stack;
        $value->setStackPath($stack);
        return $value;
    }
}
