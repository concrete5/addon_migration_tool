<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

class WorkflowTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $type = \Concrete\Core\Workflow\Type::getByHandle($this->object->getHandle());

        return is_object($type);
    }
}
