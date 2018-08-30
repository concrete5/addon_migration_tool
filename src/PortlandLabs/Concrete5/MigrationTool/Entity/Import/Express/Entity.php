<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ExpressEntityValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\GroupValidator;
use Doctrine\ORM\Mapping as ORM;
use Concrete\Core\Entity\Express\Entity as CoreExpressEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressEntities")
 */
class Entity implements PublishableInterface, LoggableInterface
{

    /**
     * @ORM\ManyToOne(targetEntity="EntityObjectCollection")
     **/
    protected $collection;

    /**
     * @ORM\OneToMany(targetEntity="Association", mappedBy="entity", cascade={"persist", "remove"})
     **/
    protected $associations;

    /**
     * @ORM\OneToMany(targetEntity="Form", mappedBy="entity", cascade={"persist", "remove"})
     **/
    protected $forms;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyObjectCollection", cascade={"persist", "remove"})
     **/
    protected $attributeKeys;

    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $handle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $plural_handle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $label_mask;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $supports_custom_display_order = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $include_in_public_list = true;

    /**
     * @ORM\Column(type="guid")
     **/
    protected $default_view_form_id;

    /**
     * @ORM\Column(type="guid")
     **/
    protected $default_edit_form_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $results_folder;


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
    public function getPluralHandle()
    {
        return $this->plural_handle;
    }

    /**
     * @param mixed $plural_handle
     */
    public function setPluralHandle($plural_handle)
    {
        $this->plural_handle = $plural_handle;
    }

    /**
     * @return mixed
     */
    public function getLabelMask()
    {
        return $this->label_mask;
    }

    /**
     * @param mixed $label_mask
     */
    public function setLabelMask($label_mask)
    {
        $this->label_mask = $label_mask;
    }

    /**
     * @return mixed
     */
    public function getSupportsCustomDisplayOrder()
    {
        return $this->supports_custom_display_order;
    }

    /**
     * @param mixed $supports_custom_display_order
     */
    public function setSupportsCustomDisplayOrder($supports_custom_display_order)
    {
        $this->supports_custom_display_order = $supports_custom_display_order;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIncludeInPublicList()
    {
        return $this->include_in_public_list;
    }

    /**
     * @param mixed $include_in_public_list
     */
    public function setIncludeInPublicList($include_in_public_list)
    {
        $this->include_in_public_list = $include_in_public_list;
    }

    /**
     * @return mixed
     */
    public function getDefaultViewFormId()
    {
        return $this->default_view_form_id;
    }

    /**
     * @param mixed $default_view_form_id
     */
    public function setDefaultViewFormId($default_view_form_id)
    {
        $this->default_view_form_id = $default_view_form_id;
    }

    /**
     * @return mixed
     */
    public function getDefaultEditFormId()
    {
        return $this->default_edit_form_id;
    }

    /**
     * @param mixed $default_edit_form_id
     */
    public function setDefaultEditFormId($default_edit_form_id)
    {
        $this->default_edit_form_id = $default_edit_form_id;
    }


    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return mixed
     */
    public function getResultsFolder()
    {
        return $this->results_folder;
    }

    /**
     * @param mixed $results_folder
     */
    public function setResultsFolder($results_folder)
    {
        $this->results_folder = $results_folder;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    public function getPublisherValidator()
    {
        return new ExpressEntityValidator($this);
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $entity = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\ExpressEntity();
        $entity->setName($this->getName());
        return $entity;
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

    /**
     * @return mixed
     */
    public function getAttributeKeys()
    {
        return $this->attributeKeys;
    }

    /**
     * @param mixed $attributeKeys
     */
    public function setAttributeKeys($attributeKeys)
    {
        $this->attributeKeys = $attributeKeys;
    }

    public function __construct()
    {
        $this->forms = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getForms()
    {
        return $this->forms;
    }

    /**
     * @param mixed $forms
     */
    public function setForms($forms)
    {
        $this->forms = $forms;
    }




}
