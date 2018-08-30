<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new StandardBlockValue();
        $i = 0;
        foreach ($node->link as $linkNode) {
            $service = (string) $linkNode['service'];
            $record = new StandardBlockDataRecord();
            $recordData = array();
            $recordData['service'] = $service;
            $record->setData($recordData);
            $record->setPosition($i);
            $record->setValue($value);
            $value->getRecords()->add($record);
            ++$i;
        }

        return $value;
    }
}
