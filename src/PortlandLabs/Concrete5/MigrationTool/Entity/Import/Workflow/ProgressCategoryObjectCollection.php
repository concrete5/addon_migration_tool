<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\WorkflowProgressCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ProgressCategoryObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="ProgressCategory", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function getFormatter()
    {
        return new WorkflowProgressCategoryFormatter($this);
    }

    public function getType()
    {
        return 'workflow_progress_category';
    }

    public function hasRecords()
    {
        return count($this->getCategories());
    }

    public function getRecords()
    {
        return $this->getCategories();
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
