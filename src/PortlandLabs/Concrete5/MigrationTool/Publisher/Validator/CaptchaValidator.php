<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Captcha\Library;

class CaptchaValidator extends AbstractValidator
{
    public function skipItem()
    {
        $library = Library::getByHandle($this->object->getHandle());

        return is_object($library);
    }
}
