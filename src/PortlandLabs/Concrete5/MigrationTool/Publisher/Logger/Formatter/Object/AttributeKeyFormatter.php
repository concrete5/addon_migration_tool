<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object;

use HtmlObject\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\SocialLink;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKeyFormatter extends AbstractStandardFormatter
{

    public function getSkippedDescription(LoggableObject $object)
    {
        return t('Attribute key %s (type: %s, category: %s) already exists.', $object->getName(), $object->getType(), $object->getCategory());
    }

    public function getPublishStartedDescription(LoggableObject $object)
    {
        return t('Began publishing attribute key %s (type: %s, category: %s).', $object->getName(), $object->getType(), $object->getCategory());
    }

    public function getPublishCompleteDescription(LoggableObject $object)
    {
        return t('Attribute key %s (type: %s, category: %s) successfully imported.', $object->getName(), $object->getType(), $object->getCategory());
    }



}
