<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AddressAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new AddressAttributeValue();
        $value->setAddress1((string) $node->value['address1']);
        $value->setAddress2((string) $node->value['address2']);
        $value->setAddress3((string) $node->value['address3']);
        $value->setCity((string) $node->value['city']);
        $value->setStateProvince((string) $node->value['state-province']);
        $value->setPostalCode((string) $node->value['postal-code']);
        $value->setCountry((string) $node->value['country']);

        return $value;
    }
}
