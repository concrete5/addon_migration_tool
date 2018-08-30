<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Conversation\Editor\Editor;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateConversationDataRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $editors = $batch->getObjectCollection('conversation_editor');

        if ($editors) {
            foreach ($editors->getEditors() as $editor) {
                if (!$editor->getPublisherValidator()->skipItem()) {
                    $logger->logPublishStarted($editor);
                    $pkg = null;
                    if ($editor->getPackage()) {
                        $pkg = \Package::getByHandle($editor->getPackage());
                    }
                    $ce = Editor::add($editor->getHandle(),
                        $editor->getName(), $pkg);
                    $logger->logPublishComplete($editor, $ce);
                    if ($editor->getIsActive()) {
                        $ce->activate();
                    }
                } else {
                    $logger->logSkipped($editor);
                }
            }
        }

        $types = $batch->getObjectCollection('conversation_flag_type');

        if ($types) {
            foreach ($types->getTypes() as $type) {
                if (!$type->getPublisherValidator()->skipItem()) {
                    $logger->logPublishStarted($type);
                    $pkg = null;
                    if ($type->getPackage()) {
                        $pkg = \Package::getByHandle($type->getPackage());
                    }
                    $ce = \Concrete\Core\Conversation\FlagType\FlagType::add($type->getHandle());
                    $logger->logPublishComplete($type, $ce);
                } else {
                    $logger->logSkipped($type);
                }
            }
        }

        $types = $batch->getObjectCollection('conversation_rating_type');

        if ($types) {
            foreach ($types->getTypes() as $type) {
                if (!$type->getPublisherValidator()->skipItem()) {
                    $logger->logPublishStarted($type);
                    $pkg = null;
                    if ($type->getPackage()) {
                        $pkg = \Package::getByHandle($type->getPackage());
                    }
                    \Concrete\Core\Conversation\Rating\Type::add(
                        $type->getHandle(), $type->getName(), $type->getPoints(),
                        $pkg
                    );
                    $logger->logPublishComplete($type);
                } else {
                    $logger->logSkipped($type);
                }
            }
        }
    }
}
