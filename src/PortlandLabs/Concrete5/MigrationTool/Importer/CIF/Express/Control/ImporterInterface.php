<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;

interface ImporterInterface
{
    public function getEntity(\SimpleXMLElement $element);
    public function loadFromXml(Control $control, \SimpleXMLElement $element);
}
