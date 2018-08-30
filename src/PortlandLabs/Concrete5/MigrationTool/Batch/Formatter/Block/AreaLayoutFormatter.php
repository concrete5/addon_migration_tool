<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block;

defined('C5_EXECUTE') or die("Access Denied.");

class AreaLayoutFormatter extends ImportedFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Layout');
        $node->icon = 'fa fa-columns';
        $node->children = array();

        $layout = $this->value->getAreaLayout();
        $columns = $layout->getColumns();
        $i = 1;
        foreach ($columns as $column) {
            $columnNode = new \stdClass();
            $columnNode->title = t('Column %s', $i);
            $columnNode->icon = 'fa fa-align-justify';
            $columnNode->children = array();
            $blocks = $column->getBlocks();
            foreach ($blocks as $block) {
                $value = $block->getBlockValue();
                $columnNode->children[] = $value->getFormatter()->getBatchTreeNodeJsonObject();
            }
            $node->children[] = $columnNode;
            ++$i;
        }

        return $node;
    }
}
