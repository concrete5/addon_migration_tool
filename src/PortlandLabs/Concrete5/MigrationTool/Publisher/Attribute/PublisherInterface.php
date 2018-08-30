<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    public function publish(Batch $batch, $attributeKey, $subject, AttributeValue $value);
}
