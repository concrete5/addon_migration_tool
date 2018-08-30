<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Package\Package;

class PackageValidator extends AbstractValidator
{
    public function skipItem()
    {
        $pkg = Package::getByHandle($this->object->getHandle());

        return is_object($pkg);
    }
}
