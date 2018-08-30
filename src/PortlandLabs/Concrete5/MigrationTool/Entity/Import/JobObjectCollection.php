<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\JobFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class JobObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $jobs;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * @param mixed $jobs
     */
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;
    }


    public function getFormatter()
    {
        return new JobFormatter($this);
    }

    public function getType()
    {
        return 'job';
    }

    public function hasRecords()
    {
        return count($this->getJobs());
    }

    public function getRecords()
    {
        return $this->getJobs();
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
