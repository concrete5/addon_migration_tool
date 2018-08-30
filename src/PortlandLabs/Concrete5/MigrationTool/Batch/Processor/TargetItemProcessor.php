<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\ProcessorQueue as ProcessorQueue;
use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Queue\QueueFactory;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\MapContentTypesTask;

defined('C5_EXECUTE') or die("Access Denied.");

class TargetItemProcessor extends ProcessorQueue
{
    protected $section;

    public function __construct(TargetInterface $target)
    {
        parent::__construct($target);
        $batch = $target->getBatch();
        $factory = new QueueFactory();
        $this->setQueue($factory->getMapperQueue($batch)->getQueue());
        $this->registerTask(new MapContentTypesTask());
    }

}
