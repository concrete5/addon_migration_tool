<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;

abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * @var Control
     */
    protected $control;

    public function __construct(Control $control)
    {
        $this->control = $control;
    }


}
