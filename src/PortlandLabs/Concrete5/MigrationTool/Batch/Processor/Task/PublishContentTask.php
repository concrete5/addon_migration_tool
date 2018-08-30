<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Concrete\Core\Logging\Logger;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\FatalErrorEntry;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\SystemLogHandler;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishContentTask implements TaskInterface
{

    public function execute(ActionInterface $action)
    {

        ini_set('max_execution_time', 0);

        $target = $action->getTarget();
        $subject = $action->getSubject();

        // Since batch is serialized we do this:
        $em = \Database::connection()->getEntityManager();
        $batch = $em->getRepository('PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch')->findOneById($target->getBatch()->getId());

        /**
         * @var $coreLogger Logger
         */
        $coreLogger = \Core::make('log/exceptions');

        $coreLogger->pushHandler(new SystemLogHandler($target->getLogger()));

        $subject->execute($batch, $target->getLogger());

        $coreLogger->popHandler();
    }

    public function finish(ActionInterface $action)
    {
        return;
    }
}
