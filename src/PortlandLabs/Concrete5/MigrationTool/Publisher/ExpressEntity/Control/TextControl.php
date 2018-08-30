<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\ExpressEntity\Control;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;

defined('C5_EXECUTE') or die("Access Denied.");

class TextControl implements PublisherInterface
{
    /**
     * @param \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\TextControl $source
     * @param $destination
     *
     * @return mixed
     */
    public function getControl(Control $source)
    {
        $control = new \Concrete\Core\Entity\Express\Control\TextControl();
        $control->setHeadline($source->getHeadline());
        $control->setBody($source->getBody());
        return $control;
    }
}
