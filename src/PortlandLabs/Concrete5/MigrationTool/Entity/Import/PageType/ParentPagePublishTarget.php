<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType\ParentPagePublishTargetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\ParentPagePublishTargetValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ParentPagePublishTarget extends PublishTarget
{
    /**
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getFormatter()
    {
        return new ParentPagePublishTargetFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new ParentPagePublishTargetValidator($batch);
    }
}
