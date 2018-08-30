<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

class PermissionKeyCategoryValidator extends AbstractValidator
{
    public function skipItem()
    {
        $category = \Concrete\Core\Permission\Category::getByHandle($this->object->getHandle());

        return is_object($category);
    }
}
