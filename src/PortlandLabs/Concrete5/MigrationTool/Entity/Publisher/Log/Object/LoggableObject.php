<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\FormatterInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogObjects")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="objectType", type="string")
 */
abstract class LoggableObject
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry", inversedBy="object")
     **/
    protected $entry;

    /**
     * @return FormatterInterface
     */
    abstract public function getLogFormatter();

}
