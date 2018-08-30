<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressEntityAssociations")
 */
class Association
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Entity")
     **/
    protected $entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="string")
     */
    protected $source_entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $target_entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $target_property_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $inversed_by_property_name;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSourceEntity()
    {
        return $this->source_entity;
    }

    /**
     * @param mixed $source_entity
     */
    public function setSourceEntity($source_entity)
    {
        $this->source_entity = $source_entity;
    }

    /**
     * @return mixed
     */
    public function getTargetEntity()
    {
        return $this->target_entity;
    }

    /**
     * @param mixed $target_entity
     */
    public function setTargetEntity($target_entity)
    {
        $this->target_entity = $target_entity;
    }

    /**
     * @return mixed
     */
    public function getTargetPropertyName()
    {
        return $this->target_property_name;
    }

    /**
     * @param mixed $target_property_name
     */
    public function setTargetPropertyName($target_property_name)
    {
        $this->target_property_name = $target_property_name;
    }

    /**
     * @return mixed
     */
    public function getInversedByPropertyName()
    {
        return $this->inversed_by_property_name;
    }

    /**
     * @param mixed $inversed_by_property_name
     */
    public function setInversedByPropertyName($inversed_by_property_name)
    {
        $this->inversed_by_property_name = $inversed_by_property_name;
    }


}
