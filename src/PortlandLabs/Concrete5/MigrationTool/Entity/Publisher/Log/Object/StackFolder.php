<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Traits\StackTrait;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\StackFolderFormatter;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogStackFolders")
 */
class StackFolder extends LoggableObject
{

    use StackTrait;

    public function getLogFormatter()
    {
        return new StackFolderFormatter();
    }


}
