<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Block\BlockType\BlockType;

class BlockTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $type = BlockType::getByHandle($this->object->getHandle());

        return is_object($type);
    }
}
