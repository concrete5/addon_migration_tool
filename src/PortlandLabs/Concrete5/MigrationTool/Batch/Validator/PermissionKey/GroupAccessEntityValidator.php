<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey;

use Concrete\Core\User\Group\Group;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupAccessEntityValidator extends AbstractValidator
{
    public function validate($entity)
    {
        $messages = new MessageCollection();
        if (!$this->groupExists($entity->getGroupName(), $this->getBatch())) {
            $messages->add(
                new Message(t('Group %s does not exist in the site or in the current content batch', $entity->getGroupName()))
            );
        }

        return $messages;
    }

    public function groupExists($name, $batch)
    {
        $g = Group::getByName($name);
        if (is_object($g)) {
            return true;
        }

        return false;
    }
}
