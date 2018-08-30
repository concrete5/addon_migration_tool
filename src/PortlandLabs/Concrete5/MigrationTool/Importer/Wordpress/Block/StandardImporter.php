<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\ImporterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardImporter implements ImporterInterface
{
    public function createBlockValueObject()
    {
        return new StandardBlockValue();
    }

    public function parse(\SimpleXMLElement $node)
    {
        $content = $node->children('http://purl.org/rss/1.0/modules/content/');
        $recordData = array('content' => (string) $content->encoded);

        $value = $this->createBlockValueObject();

        $r = new StandardBlockDataRecord();
        $r->setTable('btContentLocal');
        $r->setData($recordData);
        $r->setValue($value);
        $r->setPosition(1);

        $value->getRecords()->add($r);

        return $value;
    }
}
