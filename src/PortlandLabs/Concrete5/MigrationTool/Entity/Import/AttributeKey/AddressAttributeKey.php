<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\AddressFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\AddressPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAddressAttributeKeys")
 */
class AddressAttributeKey extends AttributeKey
{
    /**
     * @ORM\Column(type="string")
     */
    protected $default_country;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $has_custom_countries = false;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $custom_countries = array();

    /**
     * @return mixed
     */
    public function getDefaultCountry()
    {
        return $this->default_country;
    }

    /**
     * @param mixed $default_country
     */
    public function setDefaultCountry($default_country)
    {
        $this->default_country = $default_country;
    }

    /**
     * @return mixed
     */
    public function getHasCustomCountries()
    {
        return $this->has_custom_countries;
    }

    /**
     * @param mixed $has_custom_countries
     */
    public function setHasCustomCountries($has_custom_countries)
    {
        $this->has_custom_countries = $has_custom_countries;
    }

    /**
     * @return mixed
     */
    public function getCustomCountries()
    {
        return $this->custom_countries;
    }

    /**
     * @param mixed $custom_countries
     */
    public function setCustomCountries($custom_countries)
    {
        $this->custom_countries = $custom_countries;
    }

    public function getType()
    {
        return 'address';
    }

    public function getFormatter()
    {
        return new AddressFormatter($this);
    }

    public function getTypePublisher()
    {
        return new AddressPublisher();
    }
}
