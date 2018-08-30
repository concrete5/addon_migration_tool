<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Template;

class PageTemplateValidator extends AbstractValidator
{
    public function skipItem()
    {
        $template = Template::getByHandle($this->object->getHandle());

        return is_object($template);
    }
}
