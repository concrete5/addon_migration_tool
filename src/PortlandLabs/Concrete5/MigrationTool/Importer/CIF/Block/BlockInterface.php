<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ImporterInterface;

interface BlockInterface extends ImporterInterface
{
    public function import(\SimpleXMLElement $node, $entity);
}
