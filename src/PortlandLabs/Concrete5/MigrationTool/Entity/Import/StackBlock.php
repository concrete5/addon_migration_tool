<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class StackBlock extends AbstractBlock
{
    protected $area = null;

    /**
     * @ORM\ManyToOne(targetEntity="AbstractStack")
     **/
    protected $stack;

    /**
     * @return mixed
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * @param mixed $stack
     */
    public function setStack($stack)
    {
        $this->stack = $stack;
    }
}
