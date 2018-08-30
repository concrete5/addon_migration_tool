<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item;

defined('C5_EXECUTE') or die("Access Denied.");

class Exporter
{
    public function export($item, \SimpleXMLElement $element)
    {
        // If the item is an instance of the ExportableItem class, we know this is version 8 and
        // we can call those methods. Otherwise we assume the export() method exists on this item.
        if (interface_exists('\Concrete\Core\Export\ExportableInterface') &&
            $item instanceof \Concrete\Core\Export\ExportableInterface) {
            $exporter = $item->getExporter();

            return $exporter->export($item, $element);
        } else {
            return $item->export($element);
        }
    }
}
