<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF;

defined('C5_EXECUTE') or die("Access Denied.");

interface ImporterInterface
{
    public function parse(\SimpleXMLElement $node);
}
