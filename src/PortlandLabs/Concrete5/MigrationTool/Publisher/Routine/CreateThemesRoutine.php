<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Theme\Theme;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateThemesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $themes = $batch->getObjectCollection('theme');

        if (!$themes) {
            return;
        }

        foreach ($themes->getThemes() as $theme) {
            if (!$theme->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($theme);
                $pkg = null;
                if ($theme->getPackage()) {
                    $pkg = \Package::getByHandle($theme->getPackage());
                }
                $t = Theme::add($theme->getHandle(), $pkg);
                if ($theme->getIsActivated()) {
                    $t->applyToSite();
                }
                $logger->logPublishComplete($theme);
            } else {
                $logger->logSkipped($theme);
            }
        }
    }
}
