<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageCollectionFormatter extends MessageFormatter
{
    protected $collection;

    public function __construct(MessageCollection $collection)
    {
        $this->collection = $collection;
    }

    protected function getSeverity()
    {
        $severity = false;
        if ($this->collection->count() > 0) {
            $severity = Message::E_INFO;
            foreach ($this->collection as $message) {
                if ($message->getSeverity() == Message::E_DANGER) {
                    $severity = Message::E_DANGER;
                    break;
                }

                if ($message->getSeverity() == Message::E_WARNING) {
                    $severity = Message::E_WARNING;
                }
            }
        }

        return $severity;
    }

    public function getSortedMessages()
    {
        // First, we filter out the duplicates
        $messageObjects = array();
        foreach (array_unique($this->collection->toArray()) as $message) {
            $messageObjects[] = $message;
        }

        // Now, we sort based on priority
        usort($messageObjects, function($m1, $m2) {
            /**
             * @var $m1 Message
             */
            if ($m1->getSeverity() > $m2->getSeverity()) {
                return -1;
            } else if ($m2->getSeverity() > $m1->getSeverity()) {
                return 1;
            } else {
                return strnatcasecmp($m1->getText(), $m2->getText());
            }
        });

        return $messageObjects;
    }

    public function getCollectionStatusIconClass()
    {
        if ($this->collection->count() > 0) {
            return sprintf("%s %s",
                $this->getLevelClass(),
                $this->getIconClass()
            );
        } else {
            return 'fa fa-thumbs-up text-success';
        }
    }
}
