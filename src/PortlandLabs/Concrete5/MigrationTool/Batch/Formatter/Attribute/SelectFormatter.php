<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectFormatter implements TreeContentItemFormatterInterface
{
    protected $value;

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = $this->value->getAttribute()->getHandle();
        $node->itemvalue = h(implode(', ', $this->value->getValue()));
        $node->icon = 'fa fa-list';

        return $node;
    }

    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }
}
