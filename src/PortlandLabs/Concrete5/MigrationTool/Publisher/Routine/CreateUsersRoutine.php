<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use PortlandLabs\CalendarImport\Entity\Import\Event;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\AbstractPageRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\RoutineInterface;

class CreateUsersRoutine implements RoutineInterface
{

    public function getPublisherRoutineActions(BatchInterface $batch)
    {
        $events = $batch->getObjectCollection('user');

        if (!$events) {
            return array();
        }

        $actions = array();
        foreach ($events->getUsers() as $user) {
            if (!$user->getPublisherValidator()->skipItem()) {
                $action = new CreateUsersRoutineAction($user);
                $actions[] = $action;
            }
        }

        return $actions;

    }

}
