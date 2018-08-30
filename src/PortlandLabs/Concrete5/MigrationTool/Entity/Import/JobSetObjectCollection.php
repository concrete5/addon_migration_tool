<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\JobSetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class JobSetObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="JobSet", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $sets;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSets()
    {
        return $this->sets;
    }

    public function getFormatter()
    {
        return new JobSetFormatter($this);
    }

    public function getType()
    {
        return 'job_set';
    }

    public function hasRecords()
    {
        return count($this->getSets());
    }

    public function getRecords()
    {
        return $this->getSets();
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
