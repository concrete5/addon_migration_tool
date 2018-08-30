<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Single;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSinglePageStructureRoutineAction extends AbstractPageAction
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $pkg = null;
        $page = $this->page;
        $logger->logPublishStarted($page);
        if ($page->getPackage()) {
            $pkg = \Package::getByHandle($page->getPackage());
        }

        if ($page->getIsGlobal()) {
            $c = Single::addGlobal($page->getOriginalPath(), $pkg);
        } else {
            $siteTree = $batch->getSite()->getSiteTreeObject();
            $c = Single::createPageInTree($page->getOriginalPath(), $siteTree, $page->getIsAtRoot(), $pkg);
        }

        if (is_object($c)) {
            $data['name'] = $page->getName();
            $data['description'] = $page->getDescription();
            $c->update($data);
            $logger->logPublishComplete($page, $c);
        } else {
            $logger->logSkipped($page);
        }
    }
}
