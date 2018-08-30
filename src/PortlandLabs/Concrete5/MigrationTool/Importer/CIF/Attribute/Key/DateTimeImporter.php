<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\DateTimeAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class DateTimeImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new DateTimeAttributeKey();
    }

    /**
     * @param DateTimeAttributeKey $key
     * @param \SimpleXMLElement $element
     */
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $mode = (string) $element->type['mode'];
        $key->setMode($mode);
    }
}
