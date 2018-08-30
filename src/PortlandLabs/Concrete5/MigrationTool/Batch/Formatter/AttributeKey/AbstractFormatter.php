<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractFormatter implements TreeContentItemFormatterInterface
{
    protected $key;

    public function __construct(AttributeKey $key)
    {
        $this->key = $key;
    }

    protected function deliverTreeNodeDataJsonObject($children)
    {
        $node = new \stdClass();
        $node->title = t('Data');
        $node->icon = 'fa fa-database';
        $node->children = $children;

        return $node;
    }
}
