<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\StackValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="MigrationImportStacks")
 */
abstract class AbstractStack implements PublishableInterface, LoggableInterface
{
    abstract public function getType();
    abstract public function createStackPublisherLogObject();

    abstract public function getStackFormatter();

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $path;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="StackObjectCollection")
     **/
    protected $collection;

    /**
     * @ORM\OneToMany(targetEntity="StackBlock", mappedBy="stack", cascade={"persist", "remove"})
     */
    protected $blocks;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position;

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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param mixed $blocks
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;
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

    public function getPublisherValidator()
    {
        return new StackValidator($this);
    }

    public function getBatchPath()
    {
        // Some methods that interact with this object need this method. Should be an interface
        // but oh well.
        return $this->getPath();
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $object = $this->createStackPublisherLogObject();
        $object->setName($this->getName());
        $object->setPath($this->getPath());
        if (is_object($publishedObject)) {
            $object->setPublishedPageID($publishedObject->getCollectionID());
        }
        return $object;
    }

}
