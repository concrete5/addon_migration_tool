<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectFormatter extends AbstractFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $nodes = array();

        $node = new \stdClass();
        $node->title = t('Allows Multiple Values');
        $node->itemvalue = $this->key->getAllowMultipleValues() ? t('Yes') : t('No');
        $nodes[] = $node;

        $node = new \stdClass();
        $node->title = t('Allows Other Values');
        $node->itemvalue = $this->key->getAllowOtherValues() ? t('Yes') : t('No');
        $nodes[] = $node;

        $node = new \stdClass();
        $node->title = t('Display Order');
        $node->itemvalue = $this->key->getDisplayOrder();
        $nodes[] = $node;

        $node = new \stdClass();
        $node->title = t('Options');
        $node->children = array();

        foreach ($this->key->getOptions() as $option) {
            $child = new \stdClass();
            $child->title = $option['value'];
            $node->children[] = $child;
        }
        $nodes[] = $node;

        return $this->deliverTreeNodeDataJsonObject($nodes);
    }
}
