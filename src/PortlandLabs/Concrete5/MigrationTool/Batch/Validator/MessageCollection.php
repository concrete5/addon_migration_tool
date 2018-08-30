<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use Doctrine\Common\Collections\ArrayCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageCollection extends ArrayCollection implements \JsonSerializable
{
    public function getFormatter()
    {
        return new MessageCollectionFormatter($this);
    }

    public function jsonSerialize()
    {
        $result = array();
        foreach ($this as $message) {
            $result[] = $message;
        }

        return $result;
    }

    public function addMessages(MessageCollection $collection = null)
    {
        if (is_object($collection) && count($collection)) {
            foreach ($collection as $message) {
                if (!in_array($message, $this->getValues())) {
                    $this->add($message);
                }
            }
        }
    }
}
