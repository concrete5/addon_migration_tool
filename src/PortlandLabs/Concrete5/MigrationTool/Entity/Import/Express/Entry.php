<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ValidatableAttributesInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ExpressEntryValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\GroupValidator;
use Doctrine\ORM\Mapping as ORM;
use Concrete\Core\Entity\Express\Entity as CoreExpressEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressEntries")
 */
class Entry implements PublishableInterface, LoggableInterface, ValidatableAttributesInterface
{

    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $display_order;

    /**
     * @ORM\Column(type="string")
     */
    protected $entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $importID;

    /**
     * @ORM\Column(type="string")
     */
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="EntryAttribute", mappedBy="entry", cascade={"persist", "remove"})
     **/
    protected $attributes;

    /**
     * @ORM\OneToMany(targetEntity="EntryAssociation", mappedBy="entry", cascade={"persist", "remove"})
     **/
    protected $associations;

    /**
     * @ORM\ManyToOne(targetEntity="EntryObjectCollection")
     **/
    protected $collection;

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function getPublisherValidator()
    {
        return new ExpressEntryValidator($this);
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $entry = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\ExpressEntry();
        $entry->setComputedName($this->getLabel());
        $entry->setOriginalId($this->getId());
        $entry->setPublishedEntry($publishedObject);
        return $entry;
    }

    /**
     * @return mixed
     */
    public function getAssociations()
    {
        return $this->associations;
    }

    /**
     * @param mixed $associations
     */
    public function setAssociations($associations)
    {
        $this->associations = $associations;
    }

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDisplayOrder()
    {
        return $this->display_order;
    }

    /**
     * @param mixed $display_order
     */
    public function setDisplayOrder($display_order)
    {
        $this->display_order = $display_order;
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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getImportID()
    {
        return $this->importID;
    }

    /**
     * @param mixed $importID
     */
    public function setImportID($importID)
    {
        $this->importID = $importID;
    }

    public function getAttributeValidatorDriver()
    {
        return 'express_attribute';
    }


}
