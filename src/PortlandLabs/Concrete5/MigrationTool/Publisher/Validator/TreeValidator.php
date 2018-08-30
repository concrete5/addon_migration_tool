<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Tree\Type\Topic;

class TreeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $tree = Topic::getByName($this->object->getName());

        return is_object($tree);
    }
}
