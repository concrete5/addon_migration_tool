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

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateAttributesTask implements TaskInterface
{
    protected $mappers;

    public function __construct(MapperManagerInterface $mappers = null)
    {
        $this->mappers = $mappers ? $mappers : \Core::make('migration/manager/mapping');
    }

    public function execute(ActionInterface $action)
    {
        /**
         * @var $subject ValidatableAttributesInterface
         */
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $attributeMapper = $this->mappers->driver($subject->getAttributeValidatorDriver());
        $targetItemList = $this->mappers->createTargetItemList($target->getBatch(), $attributeMapper);
        foreach ($subject->getAttributes() as $attribute) {
            $item = new Item($attribute->getAttribute()->getHandle());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if (!($targetItem instanceof IgnoredTargetItem)) {
                if ($targetItem instanceof UnmappedTargetItem) {
                    $action->getTarget()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> does not exist.', $item->getIdentifier()), Message::E_WARNING)
                    );
                }

                $value = $attribute->getAttribute()->getAttributeValue();
                if ($value instanceof ImportedAttributeValue) {
                    $action->getTarget()->addMessage(
                        new Message(t('Attribute <strong>%s</strong> could not be mapped to a known attribute type. It may not be fully imported.', $item->getIdentifier()), Message::E_WARNING)
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
