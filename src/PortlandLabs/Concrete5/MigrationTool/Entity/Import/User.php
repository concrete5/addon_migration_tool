<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ValidatableAttributesInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\UserValidator;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\User as UserLogger;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportUsers")
 */
class User implements PublishableInterface, LoggableInterface, ValidatableAttributesInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserObjectCollection")
     **/
    protected $collection;

    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserAttribute", mappedBy="user", cascade={"persist", "remove"})
     **/
    public $attributes;

    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserGroup", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\OrderBy({"name" = "ASC"})
     **/
    public $groups;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $language;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $timezone;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_active = true;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_validated = true;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->groups = new ArrayCollection();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function getIsValidated()
    {
        return $this->is_validated;
    }

    /**
     * @param mixed $is_validated
     */
    public function setIsValidated($is_validated)
    {
        $this->is_validated = $is_validated;
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
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    public function getPublisherValidator()
    {
        return new UserValidator($this);
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $object = new UserLogger();
        $object->setName($this->getName());
        if ($publishedObject) {
            $object->setCoreUser($publishedObject);
        }
        return $object;
    }

    public function getAttributeValidatorDriver()
    {
        return 'user_attribute';
    }


}
