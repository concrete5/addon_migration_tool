<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry\FormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogEntries")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class Entry
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="Log", inversedBy="entries")
     **/
    protected $log;

    public function __construct(LoggableObject $object = null)
    {
        $this->timestamp = new \DateTime();
        if (is_object($object)) {
            $this->object = $object;
            $this->object->setEntry($this);
        }
    }

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject", mappedBy="entry",  cascade={"persist","remove"})
     **/
    protected $object;

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return mixed
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param mixed $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return FormatterInterface
     */
    abstract public function getEntryFormatter();




}
