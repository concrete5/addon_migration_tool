<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Type\PublishTarget\Type\Type;

class PageTypePublishTargetTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $editor = Type::getByHandle($this->object->getHandle());

        return is_object($editor);
    }
}
