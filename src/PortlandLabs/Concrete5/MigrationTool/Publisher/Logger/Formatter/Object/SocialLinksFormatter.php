<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\SocialLink;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Social Link for service %s (%s) already exists.', $object->getService(), $object->getUrl());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Creating Social Link for service %s (%s).', $object->getService(), $object->getUrl());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        $a = new Link(
            \URL::to('/dashboard/system/basics/social', 'edit', $object->getLink()->getID()),
            t('Social Link for service %s (%s) published.', $object->getService(), $object->getUrl())
        );
        return $a;
    }


}
