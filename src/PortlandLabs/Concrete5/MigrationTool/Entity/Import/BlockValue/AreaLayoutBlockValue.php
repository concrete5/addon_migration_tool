<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\AreaLayoutFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\AreaLayoutInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\AreaLayoutPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="MigrationImportAreaLayoutBlockValues")
 * @ORM\Entity
 */
class AreaLayoutBlockValue extends BlockValue
{
    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout", inversedBy="block_value", cascade={"persist", "remove"})
     **/
    protected $area_layout;

    /**
     * @return \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout
     */
    public function getAreaLayout()
    {
        return $this->area_layout;
    }

    /**
     * @param mixed $area_layout
     */
    public function setAreaLayout($area_layout)
    {
        $this->area_layout = $area_layout;
    }

    public function getInspector()
    {
        return new AreaLayoutInspector($this);
    }

    public function getFormatter()
    {
        return new AreaLayoutFormatter($this);
    }

    public function getPublisher()
    {
        return new AreaLayoutPublisher();
    }
}
