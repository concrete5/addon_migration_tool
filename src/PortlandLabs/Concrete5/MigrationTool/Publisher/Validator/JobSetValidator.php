<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

class JobSetValidator extends AbstractValidator
{
    public function skipItem()
    {
        $set = \Concrete\Core\Job\Set::getByName($this->object->getName());

        return is_object($set);
    }
}
