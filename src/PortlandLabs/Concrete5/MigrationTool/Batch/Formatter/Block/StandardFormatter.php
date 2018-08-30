<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardFormatter extends ImportedFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = $this->value->getBlock()->getType();
        $node->icon = 'fa fa-cube';
        $node->children = array();
        foreach ($this->value->getRecords() as $record) {
            $node2 = new \stdClass();
            $node2->title = $record->getTable();
            $node2->icon = 'fa fa-database';
            $node2->children = array();
            foreach ($record->getData() as $key => $value) {
                $child = new \stdClass();
                $child->title = $key;
                $child->itemvalue = h($value);
                $node2->children[] = $child;
            }
            $node->children[] = $node2;
        }

        return $node;
    }
}
