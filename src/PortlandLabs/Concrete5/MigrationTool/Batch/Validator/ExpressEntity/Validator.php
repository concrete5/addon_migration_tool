<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ExpressEntity;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UnknownAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entity;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{
    /**
     * @param $entity Entity
     * @return MessageCollection
     */
    public function validate($entity)
    {
        $messages = new MessageCollection();
        $keys = $entity->getAttributeKeys();
        if ($keys) {
            foreach($keys->getKeys() as $key) {
                if ($key instanceof UnknownAttributeKey) {
                    $messages->add(
                        new Message(t('Attribute key is of an unknown type. It may not be imported properly.'))
                    );
                }

                $validator = $key->getRecordValidator($this->getBatch());
                if (is_object($validator)) {
                    $r = $validator->validate($key);
                    $messages->addMessages($r);
                }
            }

        }
        return $messages;
    }
}
