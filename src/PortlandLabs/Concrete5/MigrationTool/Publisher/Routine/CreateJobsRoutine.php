<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Job\Job;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateJobsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $jobs = $batch->getObjectCollection('job');

        if (!$jobs) {
            return;
        }

        foreach ($jobs->getJobs() as $job) {
            if (!$job->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($job);
                $pkg = null;
                if ($job->getPackage()) {
                    $pkg = \Package::getByHandle($job->getPackage());
                }
                if (is_object($pkg)) {
                    Job::installByPackage($job->getHandle(), $pkg);
                } else {
                    Job::installByHandle($job->getHandle());
                }
                $logger->logPublishComplete($job);
            } else {
                $logger->logSkipped($job);
            }
        }
    }
}
