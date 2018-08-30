<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Settings\AddressSettings;
use Concrete\Core\Entity\Attribute\Key\Type\AddressType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressPublisher extends AbstractPublisher
{
    public function publish(AttributeKey $source, $destination)
    {
        // version 8
        $settings = new AddressSettings();
        $settings->setHasCustomCountries($source->getHasCustomCountries());
        $settings->setDefaultCountry($source->getDefaultCountry());
        $settings->setCustomCountries($source->getCustomCountries());
        return $this->publishAttribute($source, $settings, $destination);
    }
}
