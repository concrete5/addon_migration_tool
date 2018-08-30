<?php
namespace PortlandLabs\Concrete5\MigrationTool\Inspector\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Inspector\InspectorInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardInspector implements InspectorInterface
{
    protected $value;

    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }

    public function getMatchedItems(Batch $batch)
    {
        $value = $this->value->getValue();
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($value);
        $items = $result->getMatchedItems();

        return $items;
    }
}
