<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher implements PublisherInterface
{
    public function publish(Batch $batch, $attributeKey, $subject, AttributeValue $value)
    {
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($value->getValue());
        $content = $result->getReplacedContent();
        $subject->setAttribute($attributeKey->getAttributeKeyHandle(), $content);
    }
}
