<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress;

defined('C5_EXECUTE') or die("Access Denied.");

interface ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $xml, array $namespaces);
}
