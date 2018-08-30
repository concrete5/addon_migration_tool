<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

defined('C5_EXECUTE') or die("Access Denied.");

class StackDisplayFormatter extends ImportedFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('core_stack_display');
        $node->icon = 'fa fa-clipboard';
        $node->children = array();
        $node->itemvalue = h($this->value->getStackPath());
        return $node;
    }
}
