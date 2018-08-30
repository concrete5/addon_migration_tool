<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PageTypeValidator;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportPageTypes")
 */
class PageType implements PublishableInterface, LoggableInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="PageTypeObjectCollection")
     **/
    protected $collection;

    /**
     * @ORM\OneToOne(targetEntity="PublishTarget", inversedBy="type", cascade={"persist", "remove"})
     **/
    protected $publish_target;

    /**
     * @ORM\Column(type="string")
     */
    protected $handle;

    /**
     * @ORM\Column(type="string")
     */
    protected $allowed_templates;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $templates = array();

    /**
     * @ORM\Column(type="string")
     */
    protected $default_template;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_internal = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_frequently_added = false;

    /**
     * @ORM\Column(type="string")
     */
    protected $launch_in_composer = true;

    /**
     * @ORM\OneToMany(targetEntity="ComposerFormLayoutSet", mappedBy="type", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     **/
    public $layout_sets;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection", cascade={"persist", "remove"})
     **/
    public $default_page_collection;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $package = null;

    /**
     * @return mixed
     */
    public function __construct()
    {
        $this->layout_sets = new ArrayCollection();
        $this->default_page_collection = new ArrayCollection();
    }

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

    public function getPublisherValidator()
    {
        return new PageTypeValidator($this);
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    /**
     * @return mixed
     */
    public function getAllowedTemplates()
    {
        return $this->allowed_templates;
    }

    /**
     * @param mixed $allowed_templates
     */
    public function setAllowedTemplates($allowed_templates)
    {
        $this->allowed_templates = $allowed_templates;
    }

    /**
     * @return mixed
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @param mixed $templates
     */
    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }

    /**
     * @return mixed
     */
    public function getDefaultTemplate()
    {
        return $this->default_template;
    }

    /**
     * @param mixed $default_template
     */
    public function setDefaultTemplate($default_template)
    {
        $this->default_template = $default_template;
    }

    /**
     * @return mixed
     */
    public function getIsInternal()
    {
        return $this->is_internal;
    }

    /**
     * @param mixed $is_internal
     */
    public function setIsInternal($is_internal)
    {
        $this->is_internal = $is_internal;
    }

    /**
     * @return mixed
     */
    public function getIsFrequentlyAdded()
    {
        return $this->is_frequently_added;
    }

    /**
     * @param mixed $is_frequently_added
     */
    public function setIsFrequentlyAdded($is_frequently_added)
    {
        $this->is_frequently_added = $is_frequently_added;
    }

    /**
     * @return mixed
     */
    public function getLaunchInComposer()
    {
        return $this->launch_in_composer;
    }

    /**
     * @param mixed $launch_in_composer
     */
    public function setLaunchInComposer($launch_in_composer)
    {
        $this->launch_in_composer = $launch_in_composer;
    }

    /**
     * @return mixed
     */
    public function getLayoutSets()
    {
        return $this->layout_sets;
    }

    /**
     * @param mixed $layout_sets
     */
    public function setLayoutSets($layout_sets)
    {
        $this->layout_sets = $layout_sets;
    }

    /**
     * @return mixed
     */
    public function getPublishTarget()
    {
        return $this->publish_target;
    }

    /**
     * @param mixed $publish_target
     */
    public function setPublishTarget($publish_target)
    {
        $this->publish_target = $publish_target;
    }

    /**
     * @return mixed
     */
    public function getDefaultPageCollection()
    {
        return $this->default_page_collection;
    }

    /**
     * @param mixed $default_page_collection
     */
    public function setDefaultPageCollection($default_page_collection)
    {
        $this->default_page_collection = $default_page_collection;
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\PageType();
        $type->setName($this->getName());
        $type->setHandle($this->getHandle());
        if (is_object($publishedObject)) {
            $type->setPublishedPageTypeID($publishedObject->getPageTypeID());
        }
        return $type;
    }

}
