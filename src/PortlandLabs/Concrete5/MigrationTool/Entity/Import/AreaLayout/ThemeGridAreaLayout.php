<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout\ThemeGridAreaLayoutPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ThemeGridAreaLayout extends AreaLayout
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $max_columns = 0;

    /**
     * @return mixed
     */
    public function getMaxColumns()
    {
        return $this->max_columns;
    }

    /**
     * @param mixed $max_columns
     */
    public function setMaxColumns($max_columns)
    {
        $this->max_columns = $max_columns;
    }

    public function getPublisher()
    {
        return new ThemeGridAreaLayoutPublisher();
    }
}
