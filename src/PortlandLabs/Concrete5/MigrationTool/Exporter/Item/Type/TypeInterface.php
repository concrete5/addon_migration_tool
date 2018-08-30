<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

interface TypeInterface
{
    public function getHandle();
    public function getPluralDisplayName();
    public function getResultsFormatter(Batch $batch);
    public function getItemsFromRequest($array);
    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element);
}
