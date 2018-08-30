<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\AreaLayoutFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StackDisplayFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\AreaLayoutInspector;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\NullInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\AreaLayoutPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="MigrationImportStackDisplayBlockValues")
 * @ORM\Entity
 */
class StackDisplayBlockValue extends BlockValue
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $stack_path;

    /**
     * @return mixed
     */
    public function getStackPath()
    {
        return $this->stack_path;
    }

    /**
     * @param mixed $stack
     */
    public function setStackPath($stack_path)
    {
        $this->stack_path = $stack_path;
    }


    public function getInspector()
    {
        return new NullInspector($this);
    }

    public function getFormatter()
    {
        return new StackDisplayFormatter($this);
    }

    public function getPublisher()
    {
        $manager = \Core::make('migration/manager/publisher/block');
        return $manager->driver('core_stack_display');
    }
}
