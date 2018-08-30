<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Stack\Stack;

class StackValidator extends AbstractValidator
{
    public function skipItem()
    {
        if ($this->object->getPath()) {
            $c = Stack::getByPath($this->object->getPath());
        } else {
            $c = Stack::getByName($this->object->getName());
        }
        if (is_object($c)) {
            $blocks = $c->getBlocks();
            if (count($blocks)) {
                return true;
            }
        }

        return false;
    }
}
