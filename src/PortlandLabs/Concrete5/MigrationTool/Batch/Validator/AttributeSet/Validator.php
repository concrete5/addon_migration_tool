<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeSet;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{
    public function validate($set)
    {
        $messages = new MessageCollection();
        $manager = \Core::make('migration/manager/import/attribute/category');
        $mapper = $manager->getAttributeCategoryMapper($set->getCategory());
        $targetItemList = new TargetItemList($this->getBatch(), $mapper);
        foreach ($set->getAttributes() as $attribute) {
            $item = new Item($attribute);
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $messages->add(
                    new Message(t('Attribute <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                );
            }
        }

        return $messages;
    }
}
