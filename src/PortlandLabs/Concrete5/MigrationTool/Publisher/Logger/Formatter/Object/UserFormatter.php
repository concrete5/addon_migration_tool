<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;

defined('C5_EXECUTE') or die("Access Denied.");

class UserFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('User %s already exists.', $object->getName());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Creating user %s.', $object->getName());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        $a = new Link(
            \URL::to('/dashboard/users/search', 'view', $object->getCoreUser()->getUserID()),
            t('User %s created.', $object->getName())
        );
        return $a;
    }



}
