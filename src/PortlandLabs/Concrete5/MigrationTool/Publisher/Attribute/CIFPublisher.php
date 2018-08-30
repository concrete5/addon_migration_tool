<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFPublisher implements PublisherInterface
{
    public function publish(Batch $batch, $ak, $subject, AttributeValue $value)
    {
        $node = simplexml_load_string($value->getValue());
        $subject->setAttribute($ak->getAttributeKeyHandle(), $ak->getController()->importValue($node));
    }
}
