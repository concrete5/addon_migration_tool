<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $xml, Batch $batch);
}
