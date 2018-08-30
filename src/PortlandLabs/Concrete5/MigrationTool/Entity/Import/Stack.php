<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\StackFormatter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Stack extends AbstractStack
{
    public function getType()
    {
        return 'stack';
    }

    public function getStackFormatter()
    {
        return new StackFormatter($this);
    }

    public function createStackPublisherLogObject()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Stack();
    }

}
