<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\File\Image\Thumbnail\Type\Type;

class ThumbnailTypeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $type = Type::getByHandle($this->object->getHandle());

        return is_object($type);
    }
}
