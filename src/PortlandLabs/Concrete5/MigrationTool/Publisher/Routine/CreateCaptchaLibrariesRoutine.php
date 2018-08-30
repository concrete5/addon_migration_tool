<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Captcha\Library;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateCaptchaLibrariesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $libraries = $batch->getObjectCollection('captcha_library');

        if (!$libraries) {
            return;
        }

        foreach ($libraries->getLibraries() as $library) {
            if (!$library->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($library);
                $pkg = null;
                if ($library->getPackage()) {
                    $pkg = \Package::getByHandle($library->getPackage());
                }
                $l = Library::add($library->getHandle(), $library->getName(), $pkg);
                if ($library->getIsActivated()) {
                    $l->activate();
                }
                $logger->logPublishComplete($library, $l);
            } else {
                $logger->logSkipped($library);
            }
        }
    }
}
