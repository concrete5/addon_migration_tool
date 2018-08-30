<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\AttributeKeyControl;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\TextControl;

class AttributeKeyImporter implements ImporterInterface
{
    public function getEntity(\SimpleXMLElement $element)
    {
        return new AttributeKeyControl();
    }

    /**
     * @param AttributeKeyControl $control
     * @param \SimpleXMLElement $element
     * @return bool
     */
    public function loadFromXml(Control $control, \SimpleXMLElement $element)
    {
        $control->setAttributeKey((string) $element->attributekey['handle']);
        return $control;
    }
}
