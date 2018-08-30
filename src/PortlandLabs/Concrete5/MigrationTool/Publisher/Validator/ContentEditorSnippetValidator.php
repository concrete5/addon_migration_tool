<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Editor\Snippet;

class ContentEditorSnippetValidator extends AbstractValidator
{
    public function skipItem()
    {
        $snippet = Snippet::getByHandle($this->object->getHandle());

        return is_object($snippet);
    }
}
