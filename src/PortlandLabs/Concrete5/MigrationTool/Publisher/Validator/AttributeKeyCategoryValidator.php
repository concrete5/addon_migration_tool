<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Attribute\Key\Category;

class AttributeKeyCategoryValidator extends AbstractValidator
{
    public function skipItem()
    {
        $category = Category::getByHandle($this->object->getHandle());

        return is_object($category);
    }
}
