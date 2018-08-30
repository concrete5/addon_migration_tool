<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger;

use Concrete\Core\Entity\Site\Site;
use Concrete\Core\Entity\User\User;
use Concrete\Core\Logging\Logger as CoreLogger;
use Concrete\Core\Permission\Access\Entity\Entity;
use Concrete\Core\Support\Facade\Facade;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\HandlerWrapper;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\FatalErrorEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\PublishCompleteEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\PublishStartedEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\SkippedEntry;
use Monolog\Formatter\FormatterInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class SystemLogHandler extends AbstractHandler
{

    protected $publisherLogger;

    public function __construct(LoggerInterface $publisherLogger)
    {
        $this->publisherLogger = $publisherLogger;
        parent::__construct(CoreLogger::EMERGENCY);
    }

    public function handle(array $record)
    {
        $exception = $record['context'][0];
        if ($exception instanceof \Exception) {
            $entry = new FatalErrorEntry();
            $entry->setMessage($exception->getMessage());
            $entry->setFilename($exception->getFile());
            $entry->setLine($exception->getLine());
            $this->publisherLogger->logEntry($entry);
        }
    }

}