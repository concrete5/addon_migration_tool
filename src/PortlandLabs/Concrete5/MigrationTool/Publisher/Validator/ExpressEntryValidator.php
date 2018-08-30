<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\User\Group\Group;

class ExpressEntryValidator extends AbstractValidator
{
    public function skipItem()
    {
        /*
        $entity = \Express::getObjectByHandle($this->object->getHandle());
        if ($entity) {
            return true;
        }
        */
        return false;
    }
}
