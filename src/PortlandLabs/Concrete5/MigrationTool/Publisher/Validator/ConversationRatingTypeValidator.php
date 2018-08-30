<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Conversation\Rating\Type;

class ConversationRatingTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $type = Type::getByHandle($this->object->getHandle());

        return is_object($type);
    }
}
