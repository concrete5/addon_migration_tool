<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control\AttributeKeyFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\ExpressEntity\Control\AttributeKeyControl as AttributeKeyControlPublisher;

/**
 * @ORM\Entity
 */
class AttributeKeyControl extends Control
{

    /**
     * @ORM\Column(type="string")
     */
    protected $attribute_key;

    public function getAttributeKey()
    {
        return $this->attribute_key;
    }

    /**
     * @param mixed $attribute_key
     */
    public function setAttributeKey($attribute_key)
    {
        $this->attribute_key = $attribute_key;
    }

    public function getFormatter()
    {
        return new AttributeKeyFormatter($this);
    }

    public function getControlPublisher()
    {
        return \Core::make(AttributeKeyControlPublisher::class);
    }


}
