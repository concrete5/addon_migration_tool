<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack\FolderFormatter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class StackFolder extends AbstractStack
{
    public function getType()
    {
        return 'folder';
    }

    public function getStackFormatter()
    {
        return new FolderFormatter($this);
    }

    public function createStackPublisherLogObject()
    {
        return new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\StackFolder();
    }
}
