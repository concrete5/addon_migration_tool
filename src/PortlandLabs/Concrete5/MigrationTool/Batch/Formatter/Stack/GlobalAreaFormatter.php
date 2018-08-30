<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\GlobalArea;

defined('C5_EXECUTE') or die("Access Denied.");

class GlobalAreaFormatter implements FormatterInterface
{
    protected $area;

    public function __construct(GlobalArea $area)
    {
        $this->area = $area;
    }

    public function getIconClass()
    {
        return 'fa fa-globe';
    }
}
