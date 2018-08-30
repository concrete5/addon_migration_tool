<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AddressAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new AddressAttributeKey();
    }

    /**
     * @param AddressAttributeKey $key
     * @param \SimpleXMLElement $element
     */
    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        if ((string) $element->type['custom-countries'] == '1') {
            $key->setHasCustomCountries(true);
        }
        $key->setDefaultCountry((string) $element->type['default-country']);
        $countries = array();
        if (isset($element->type->countries->country)) {
            foreach ($element->type->countries->country as $country) {
                $countries[] = (string) $country;
            }
        }
        $key->setCustomCountries($countries);
    }
}
