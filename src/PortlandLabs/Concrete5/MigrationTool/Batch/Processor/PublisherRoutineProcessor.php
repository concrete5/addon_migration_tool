<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\ProcessorQueue as ProcessorQueue;
use Concrete\Core\Foundation\Processor\TargetInterface;
use Concrete\Core\Foundation\Queue\Queue;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchService;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\PublishContentTask;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Logger;
use PortlandLabs\Concrete5\MigrationTool\Batch\Queue\QueueFactory;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PublisherRoutineProcessor extends ProcessorQueue
{
    protected $section;
    protected $logger;

    protected $itemsPerBatch = 20;

    public function __construct(TargetInterface $target, LoggerInterface $logger)
    {
        parent::__construct($target);
        $batch = $target->getBatch();
        $factory = new QueueFactory();
        $this->logger = $logger;
        $this->setQueue($factory->getPublisherQueue($batch)->getQueue());
        $this->registerTask(new PublishContentTask());
    }

    public function processWithNoErrors()
    {
        $this->startProcess();
        $this->target->setLogger($this->logger);
        parent::process();
    }

    protected function startProcess()
    {
        $u = new \User();
        $user = null;
        if ($u->isRegistered()) {
            $user = $u->getUserInfoObject()->getEntityObject();
        }
        $batchService = \Core::make(BatchService::class);
        $batchService->createImportNode($this->target->getBatch()->getSite());
        $this->logger->openLog($this->target->getBatch(), $user);
    }

    public function process()
    {
        $this->startProcess();
        $validator = \Core::make('migration/batch/validator');
        $messages = $validator->validate($this->target->getBatch());
        $formatter = $validator->getFormatter($messages);
        $this->logger->logMessages($formatter->getSortedMessages($messages));

        $this->target->setLogger($this->logger);
        parent::process();
    }

}
