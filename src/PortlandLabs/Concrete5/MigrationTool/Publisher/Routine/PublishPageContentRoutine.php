<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishPageContentRoutine extends AbstractPageRoutine
{
    public function getPageRoutineAction($page)
    {
        return new PublishPageContentRoutineAction($page);
    }
}
