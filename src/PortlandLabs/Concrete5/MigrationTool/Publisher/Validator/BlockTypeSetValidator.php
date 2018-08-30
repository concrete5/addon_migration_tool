<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Block\BlockType\Set;

class BlockTypeSetValidator extends AbstractValidator
{
    public function skipItem()
    {
        $set = Set::getByHandle($this->object->getHandle());

        return is_object($set);
    }
}
