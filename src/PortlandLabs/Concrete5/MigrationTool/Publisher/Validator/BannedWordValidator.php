<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Validation\BannedWord\BannedWord;

class BannedWordValidator extends AbstractValidator
{
    public function skipItem()
    {
        $word = BannedWord::getByWord(str_rot13($this->object->getWord()));

        return is_object($word);
    }
}
