<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Attribute\Key\CollectionKey;
use Concrete\Core\Attribute\Key\FileKey;
use Concrete\Core\Attribute\Key\UserKey;

class AttributeKeyValidator extends AbstractValidator
{
    public function skipItem()
    {
        $key = false;
        switch ($this->object->getCategory()) {
            case 'collection':
                $key = CollectionKey::getByHandle($this->object->getHandle());
                break;
            case 'file':
                $key = FileKey::getByHandle($this->object->getHandle());
                break;
            case 'user':
                $key = UserKey::getByHandle($this->object->getHandle());
                break;
        }

        return is_object($key);
    }
}
