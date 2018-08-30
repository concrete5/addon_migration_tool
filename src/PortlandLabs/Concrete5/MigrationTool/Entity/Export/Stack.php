<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Stack extends AbstractStandardExportItem
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $stack_type;

    /**
     * @return mixed
     */
    public function getStackType()
    {
        return $this->stack_type;
    }

    /**
     * @param mixed $stack_type
     */
    public function setStackType($stack_type)
    {
        $this->stack_type = $stack_type;
    }
}
