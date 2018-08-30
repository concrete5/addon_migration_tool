<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\TextControl;

class EntityPropertyImporter implements ImporterInterface
{
    public function getEntity(\SimpleXMLElement $element)
    {
        $type = (string) $element['type-id'];
        switch($type) {
            case 'text':
                return new TextControl();
        }
    }

    /**
     * @param TextControl $control
     * @param \SimpleXMLElement $element
     * @return bool
     */
    public function loadFromXml(Control $control, \SimpleXMLElement $element)
    {
        $type = (string) $element['type-id'];
        switch($type) {
            case 'text':
                $control->setHeadline((string) $element->headline);
                $control->setBody((string) $element->body);
                return $control;
        }
    }
}
