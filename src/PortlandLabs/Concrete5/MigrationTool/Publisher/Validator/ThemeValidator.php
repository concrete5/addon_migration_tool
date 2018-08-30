<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Theme\Theme;

class ThemeValidator extends AbstractValidator
{
    public function skipItem()
    {
        $theme = Theme::getByHandle($this->object->getHandle());

        return is_object($theme);
    }
}
