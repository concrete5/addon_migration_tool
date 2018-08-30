<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\EmptyMapper;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\ClosePublisherLogRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\OpenPublisherLogRoutine;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishTarget implements TargetInterface
{
    protected $batch;
    protected $logger;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return Section
     */
    public function getBatch()
    {
        return $this->batch;
    }

    public function __sleep()
    {
        return array('batch', 'logger');
    }

    public function getItems()
    {
        $items = array();
        // First we add the open publisher log
        $publishers = \Core::make('migration/manager/publisher');
        foreach ($publishers->getDrivers() as $driver) {
            foreach ($driver->getPublisherRoutineActions($this->batch) as $action) {
                $items[] = $action;
            }
        }
        $items[] = new ClosePublisherLogRoutine();
        return $items;
    }
}
