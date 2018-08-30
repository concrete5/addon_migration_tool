<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AbstractBlock;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AreaLayoutColumnBlock extends AbstractBlock
{
    protected $area = null;

    /**
     * @ORM\ManyToOne(targetEntity="AreaLayoutColumn")
     **/
    protected $column;

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }
}
