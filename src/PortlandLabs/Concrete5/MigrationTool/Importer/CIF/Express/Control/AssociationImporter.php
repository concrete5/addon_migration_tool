<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control;

use Concrete\Core\Entity\Express\Entry\Association;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\AssociationControl;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\TextControl;

class AssociationImporter implements ImporterInterface
{
    public function getEntity(\SimpleXMLElement $element)
    {
        return new AssociationControl();
    }

    /**
     * @param AssociationControl $control
     * @param \SimpleXMLElement $element
     * @return bool
     */
    public function loadFromXml(Control $control, \SimpleXMLElement $element)
    {
        $control->setAssociation((string) $element['association']);
        return $control;
    }
}
