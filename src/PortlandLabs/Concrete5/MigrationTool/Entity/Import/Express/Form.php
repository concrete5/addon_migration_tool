<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressEntityForms")
 */
class Form
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Entity")
     **/
    protected $entity;

    /**
     * @ORM\OneToMany(targetEntity="FieldSet", mappedBy="form", cascade={"persist", "remove"})
     **/
    protected $field_sets;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * Form constructor.
     */
    public function __construct()
    {
        $this->field_sets = new ArrayCollection();
    }

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
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return FieldSet
     */
    public function getFieldSets()
    {
        return $this->field_sets;
    }

    /**
     * @param mixed $field_sets
     */
    public function setFieldSets($field_sets)
    {
        $this->field_sets = $field_sets;
    }

}
