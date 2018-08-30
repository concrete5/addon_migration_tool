<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\PageTemplateFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PageTemplateObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $templates;

    public function __construct()
    {
        $this->templates = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    public function getFormatter()
    {
        return new PageTemplateFormatter($this);
    }

    public function getType()
    {
        return 'page_template';
    }

    public function hasRecords()
    {
        return count($this->getTemplates());
    }

    public function getRecords()
    {
        return $this->getTemplates();
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
