<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ImporterInterface;

interface ValueInterface extends ImporterInterface
{
    public function import(\SimpleXMLElement $node, $entity);
}
