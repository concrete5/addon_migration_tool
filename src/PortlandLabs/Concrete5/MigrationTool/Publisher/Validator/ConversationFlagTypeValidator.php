<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Conversation\FlagType\FlagType;

class ConversationFlagTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $type = FlagType::getByHandle($this->object->getHandle());

        return is_object($type);
    }
}
