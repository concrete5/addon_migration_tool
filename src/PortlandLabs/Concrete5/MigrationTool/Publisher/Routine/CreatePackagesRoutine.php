<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePackagesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $packages = $batch->getObjectCollection('package');

        if (!$packages) {
            return;
        }

        foreach ($packages->getPackages() as $package) {
            if (!$package->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($package);
                $pkg = \Package::getClass($package->getHandle());
                if (!$pkg->isPackageInstalled()) {
                    $pkg->install();
                }
                $logger->logPublishComplete($package);
            } else {
                $logger->logSkipped($package);
            }
        }
    }
}
