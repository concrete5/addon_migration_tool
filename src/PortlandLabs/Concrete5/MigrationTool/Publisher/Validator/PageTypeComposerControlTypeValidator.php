<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Type\Composer\Control\Type\Type;

class PageTypeComposerControlTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $editor = Type::getByHandle($this->object->getHandle());

        return is_object($editor);
    }
}
