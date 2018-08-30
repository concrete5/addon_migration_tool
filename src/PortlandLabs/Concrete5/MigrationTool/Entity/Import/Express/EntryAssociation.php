<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressEntryAssociations")
 */
class EntryAssociation
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $target;

    /**
     * @ORM\ManyToOne(targetEntity="Entry")
     **/
    protected $entry;

    /**
     * @ORM\OneToMany(targetEntity="AssociatedEntry", mappedBy="association", cascade={"persist", "remove"})
     **/
    protected $associatedEntries;

    public function __construct()
    {
        $this->associatedEntries = new ArrayCollection();
    }

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
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param mixed $entry
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;
    }

    /**
     * @return mixed
     */
    public function getAssociatedEntries()
    {
        return $this->associatedEntries;
    }

    /**
     * @param mixed $associatedEntries
     */
    public function setAssociatedEntries($associatedEntries)
    {
        $this->associatedEntries = $associatedEntries;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }






}
