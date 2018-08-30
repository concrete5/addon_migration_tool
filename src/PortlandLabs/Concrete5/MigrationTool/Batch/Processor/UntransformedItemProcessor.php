<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\ProcessorQueue as ProcessorQueue;
use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Queue\QueueFactory;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\TransformContentTypesTask;

defined('C5_EXECUTE') or die("Access Denied.");

class UntransformedItemProcessor extends ProcessorQueue
{
    protected $section;

    protected $itemsPerBatch = 100;

    public function __construct(TargetInterface $target)
    {
        parent::__construct($target);
        $batch = $target->getBatch();
        $factory = new QueueFactory();
        $this->setQueue($factory->getTransformerQueue($batch)->getQueue());
        $this->registerTask(new TransformContentTypesTask());
    }
}
