<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\SocialLink;

defined('C5_EXECUTE') or die("Access Denied.");

class GlobalAreaFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Global Area %s (%s) already exists.', $object->getName(), $object->getPath());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Installing Global Area %s (%s).', $object->getName(), $object->getPath());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        $a = new Link(
            \URL::to('/dashboard/blocks/stacks', 'view_details', $object->getPublishedPageID()),
            t('Global Area %s (%s) published.', $object->getName(), $object->getPath())
        );
        return $a;
    }



}
