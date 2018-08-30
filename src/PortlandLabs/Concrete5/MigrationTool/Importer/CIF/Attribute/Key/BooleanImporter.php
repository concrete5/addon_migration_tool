<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class BooleanImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new BooleanAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $checked = (string) $element->type['checked'];
        if ($checked == '1') {
            $key->setIsChecked(true);
        } else {
            $key->setIsChecked(false);
        }
    }
}
