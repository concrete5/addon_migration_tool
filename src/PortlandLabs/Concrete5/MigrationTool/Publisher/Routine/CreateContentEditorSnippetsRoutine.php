<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Editor\Snippet;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateContentEditorSnippetsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $snippets = $batch->getObjectCollection('content_editor_snippet');

        if (!$snippets) {
            return;
        }

        foreach ($snippets->getSnippets() as $snippet) {
            if (!$snippet->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($snippet);
                $pkg = null;
                if ($snippet->getPackage()) {
                    $pkg = \Package::getByHandle($snippet->getPackage());
                }
                $t = Snippet::add($snippet->getHandle(), $snippet->getNAme(), $pkg);
                $logger->logPublishComplete($snippet, $t);
                if ($snippet->getIsActivated()) {
                    $t->activate();
                }
            } else {
                $logger->logSkipped($snippet);
            }
        }
    }
}
