<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAreaAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TextAreaImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new TextAreaAttributeKey();
    }

    /**
     * @param TextAreaAttributeKey $key
     * @param \SimpleXMLElement $element
     *
     * @return bool
     */
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $mode = (string) $element->type['mode'];
        $key->setMode($mode);
    }
}
