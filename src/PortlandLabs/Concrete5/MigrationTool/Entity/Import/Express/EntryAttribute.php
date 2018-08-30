<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressEntryAttributes")
 */
class EntryAttribute implements LoggableInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute", cascade={"persist", "remove"})
     **/
    protected $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="Entry")
     **/
    protected $entry;

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
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param mixed $page
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $object = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\EntryAttribute();
        $object->setHandle($this->getAttribute()->getHandle());;
        $object->setEntry($this->getEntry()->getLabel());
        return $object;
    }

}
