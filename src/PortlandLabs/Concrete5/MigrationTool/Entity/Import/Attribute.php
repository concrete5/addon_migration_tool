<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributes")
 */
class Attribute
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $handle;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue", inversedBy="attribute", cascade={"persist", "remove"})
     **/
    protected $attribute_value;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return mixed
     */
    public function getAttributeValue()
    {
        return $this->attribute_value;
    }

    /**
     * @param mixed $value
     */
    public function setAttributeValue($attribute_value)
    {
        $this->attribute_value = $attribute_value;
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $this->attribute_value = clone $this->attribute_value;
            if (is_object($this->attribute_value)) {
                $this->attribute_value->setAttribute($this);
            }
        }
    }
}
