<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter extends AbstractImporter
{
    public function createBlockValueObject()
    {
        return new StandardBlockValue();
    }

    public function parse(\SimpleXMLElement $node)
    {
        $value = $this->createBlockValueObject();
        $position = 0;
        foreach ($node->data as $data) {
            foreach ($data->record as $record) {
                $r = new StandardBlockDataRecord();
                $r->setTable((string) $data['table']);
                $recordData = array();
                foreach ($record->children() as $field) {
                    $recordData[$field->getName()] = (string) $field;
                }
                $r->setData($recordData);
                $r->setValue($value);
                $r->setPosition($position);
                $value->getRecords()->add($r);
                ++$position;
            }
        }

        return $value;
    }
}
