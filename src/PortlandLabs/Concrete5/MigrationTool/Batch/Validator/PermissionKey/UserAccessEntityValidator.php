<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey;

use Concrete\Core\User\UserInfo;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class UserAccessEntityValidator extends AbstractValidator
{
    public function validate($entity)
    {
        $messages = new MessageCollection();
        if (!$this->userExists($entity->getUserName(), $this->getBatch())) {
            $messages->add(
                new Message(t('User %s does not exist in the site or in the current content batch', $entity->getUserName()))
            );
        }

        return $messages;
    }

    public function userExists($username, $batch)
    {
        $ui = UserInfo::getByUserName($username);
        if (is_object($ui)) {
            return true;
        }

        return false;
    }
}
