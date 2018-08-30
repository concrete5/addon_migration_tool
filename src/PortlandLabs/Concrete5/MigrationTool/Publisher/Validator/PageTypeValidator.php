<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Type\Type;

class PageTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $type = Type::getByHandle($this->object->getHandle());

        return is_object($type);
    }
}
