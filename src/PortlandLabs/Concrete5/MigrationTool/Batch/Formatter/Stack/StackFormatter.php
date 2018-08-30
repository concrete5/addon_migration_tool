<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Stack;

defined('C5_EXECUTE') or die("Access Denied.");

class StackFormatter implements FormatterInterface
{
    protected $stack;

    public function __construct(Stack $stack)
    {
        $this->stack = $stack;
    }

    public function getIconClass()
    {
        return 'fa fa-cubes';
    }
}
