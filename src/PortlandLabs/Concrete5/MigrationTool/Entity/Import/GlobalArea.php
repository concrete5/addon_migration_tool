<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\GlobalAreaFormatter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class GlobalArea extends AbstractStack
{
    public function getType()
    {
        return 'global_area';
    }

    public function getStackFormatter()
    {
        return new GlobalAreaFormatter($this);
    }

    public function createStackPublisherLogObject()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\GlobalArea();
    }

}
