<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageFeed;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{
    public function validate($feed)
    {
        $messages = new MessageCollection();
        $items = $feed->getInspector()->getMatchedItems($this->batch);
        foreach ($items as $item) {
            $validatorFactory = new Factory($item);
            $validator = $validatorFactory->getValidator();
            if (!$validator->itemExists($item, $this->getBatch())) {
                $validator->addMissingItemMessage($item, $messages);
            }
        }

        return $messages;
    }
}
