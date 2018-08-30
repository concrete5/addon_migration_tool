<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

class SiteValidator extends AbstractValidator
{
    public function skipItem()
    {
        $site = \Core::make('site')->getByHandle($this->object->getHandle());
        if (is_object($site)) {
            return true;
        }
        return false;
    }
}
