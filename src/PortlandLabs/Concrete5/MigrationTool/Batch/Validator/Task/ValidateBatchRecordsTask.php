<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateBatchRecordsTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $target = $action->getTarget();
        foreach ($subject->getObjectCollections() as $collection) {
            if ($collection->hasRecords()) {
                $validator = $collection->getRecordValidator($subject);
                if (is_object($validator)) {
                    foreach ($collection->getRecords() as $record) {
                        $messages = $validator->validate($record);
                        foreach ($messages as $message) {
                            $target->addMessage($message);
                        }
                    }
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
