<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ValidatableAttributesInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\ImportedAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateExpressAttributesTask extends ValidateAttributesTask
{

    public function execute(ActionInterface $action)
    {
        /**
         * @var $subject Entry
         */
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $attributeMapper = $this->mappers->driver($subject->getAttributeValidatorDriver());
        $targetItemList = $this->mappers->createTargetItemList($target->getBatch(), $attributeMapper);
        foreach ($subject->getAttributes() as $attribute) {
            $item = new Item($subject->getEntity() . '|' . $attribute->getAttribute()->getHandle());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (!($targetItem instanceof IgnoredTargetItem)) {
                if ($targetItem instanceof UnmappedTargetItem) {
                    $action->getTarget()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> for entity <strong>%s</strong> does not exist.', $attribute->getAttribute()->getHandle(), $subject->getEntity()), Message::E_WARNING)
                    );
                }

                $value = $attribute->getAttribute()->getAttributeValue();
                if ($value instanceof ImportedAttributeValue) {
                    $action->getTarget()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> for entity <strong>%s</strong> could not be mapped to a known attribute type. It may not be fully imported.', $attribute->getAttribute()->getHandle(), $subject->getEntity()), Message::E_WARNING)
                    );
                }

                $validator = $value->getRecordValidator($target->getBatch());
                if (is_object($validator)) {
                    $r = $validator->validate($value);
                    if (is_object($r)) {
                        foreach ($r as $message) {
                            $action->getTarget()->addMessage($message);
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
