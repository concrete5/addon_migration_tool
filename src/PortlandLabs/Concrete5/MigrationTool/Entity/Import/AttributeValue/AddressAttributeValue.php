<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\AddressFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\AddressPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeAddressValues")
 */
class AddressAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $address3;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $state_province;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $postal_code;

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getAddress3()
    {
        return $this->address3;
    }

    /**
     * @param mixed $address3
     */
    public function setAddress3($address3)
    {
        $this->address3 = $address3;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getStateProvince()
    {
        return $this->state_province;
    }

    /**
     * @param mixed $state_province
     */
    public function setStateProvince($state_province)
    {
        $this->state_province = $state_province;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    public function getFormatter()
    {
        return new AddressFormatter($this);
    }

    public function getPublisher()
    {
        return new AddressPublisher();
    }
}
