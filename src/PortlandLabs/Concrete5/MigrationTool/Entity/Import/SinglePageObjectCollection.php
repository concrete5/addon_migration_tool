<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\SinglePageFormatter;

/**
 * @ORM\Entity
 */
class SinglePageObjectCollection extends PageObjectCollection
{
    public function getType()
    {
        return 'single_page';
    }

    public function getFormatter()
    {
        return new SinglePageFormatter($this);
    }
}
