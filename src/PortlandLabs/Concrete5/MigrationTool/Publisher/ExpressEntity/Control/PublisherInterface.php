<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\ExpressEntity\Control;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    /**
     * @param Control $source
     * @param $destination
     *
     * @return mixed
     */
    public function getControl(Control $source);
}
