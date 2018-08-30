<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType\PageTypePublishTargetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\PageTypePublishTargetValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 */
class PageTypePublishTarget extends PublishTarget
{
    /**
     * @ORM\Column(type="string")
     */
    protected $page_type;

    /**
     * @ORM\Column(type="string")
     */
    protected $form_factor;

    /**
     * @return mixed
     */
    public function getPageType()
    {
        return $this->page_type;
    }

    /**
     * @param mixed $page_type
     */
    public function setPageType($page_type)
    {
        $this->page_type = $page_type;
    }

    /**
     * @return mixed
     */
    public function getFormFactor()
    {
        return $this->form_factor;
    }

    /**
     * @param mixed $form_factor
     */
    public function setFormFactor($form_factor)
    {
        $this->form_factor = $form_factor;
    }

    public function getFormatter()
    {
        return new PageTypePublishTargetFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new PageTypePublishTargetValidator($batch);
    }
}
