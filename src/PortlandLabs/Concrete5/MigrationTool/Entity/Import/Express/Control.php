<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="MigrationImportExpressEntityFormFieldSetControls")
 */
abstract class Control
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="FieldSet")
     **/
    protected $field_set;


    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_required = false;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $custom_label;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFieldSet()
    {
        return $this->field_set;
    }

    /**
     * @param mixed $field_set
     */
    public function setFieldSet($field_set)
    {
        $this->field_set = $field_set;
    }

    /**
     * @return mixed
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }

    /**
     * @param mixed $is_required
     */
    public function setIsRequired($is_required)
    {
        $this->is_required = $is_required;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getCustomLabel()
    {
        return $this->custom_label;
    }

    /**
     * @param mixed $custom_label
     */
    public function setCustomLabel($custom_label)
    {
        $this->custom_label = $custom_label;
    }


    abstract public function getFormatter();

    abstract public function getControlPublisher();





}
