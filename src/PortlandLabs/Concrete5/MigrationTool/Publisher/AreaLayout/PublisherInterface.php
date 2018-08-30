<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    /**
     * @param AreaLayout $layout
     */
    public function publish(AreaLayout $layout);
}
