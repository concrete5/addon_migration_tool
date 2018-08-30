<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="\PortlandLabs\Concrete5\MigrationTool\Entity\Export\BatchRepository")
 * @ORM\Table(name="MigrationExportBatches")
 */
class Batch
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="ObjectCollection", cascade={"persist", "remove"}))
     * @ORM\JoinTable(name="MigrationExportBatchObjectCollections",
     *      joinColumns={@ORM\JoinColumn(name="batch_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="collection_id", referencedColumnName="id", unique=true)}
     *      )
     **/
    public $collections;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->collections = new ArrayCollection();
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
    public function getObjectCollections()
    {
        return $this->collections;
    }

    /**
     * @param mixed $collections
     */
    public function setObjectCollections($collections)
    {
        $this->collections = $collections;
    }

    public function hasRecords()
    {
        return $this->collections->count() > 0;
    }

    public function getObjectCollection($type)
    {
        foreach ($this->collections as $collection) {
            if ($collection->getType() == $type) {
                return $collection;
            }
        }
    }

    /*
     * This used to work WITHOUT This but something about refactoring into ObjectCollections made this necessary in complex DQL queries.
     */
    public function __toString()
    {
        return $this->getID();
    }
}
