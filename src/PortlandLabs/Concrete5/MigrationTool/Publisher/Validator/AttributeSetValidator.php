<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

class AttributeSetValidator extends AbstractValidator
{
    public function skipItem()
    {
        $set = \Concrete\Core\Attribute\Set::getByHandle($this->object->getHandle());

        return is_object($set);
    }
}
