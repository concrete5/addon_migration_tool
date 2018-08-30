<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\Factory;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardValidator extends AbstractValidator
{
    public function validate($value)
    {
        $messages = new MessageCollection();
        $items = $value->getInspector()->getMatchedItems($this->getBatch());
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
