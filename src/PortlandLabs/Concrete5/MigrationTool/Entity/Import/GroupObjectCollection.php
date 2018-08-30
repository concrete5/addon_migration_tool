<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\GroupFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class GroupObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Group", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    public function getFormatter()
    {
        return new GroupFormatter($this);
    }

    public function getType()
    {
        return 'group';
    }

    public function hasRecords()
    {
        return count($this->getGroups());
    }

    public function getRecords()
    {
        return $this->getGroups();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return false;
    }
}
