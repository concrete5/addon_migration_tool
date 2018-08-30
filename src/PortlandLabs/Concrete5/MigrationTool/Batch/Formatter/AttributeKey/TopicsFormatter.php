<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsFormatter extends AbstractFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node1 = new \stdClass();
        $node1->title = t('Tree');
        $node1->itemvalue = $this->key->getTreeName();

        $node2 = new \stdClass();
        $node2->title = t('Path');
        $node2->itemvalue = $this->key->getNodePath();

        return $this->deliverTreeNodeDataJsonObject(array($node1, $node2));
    }
}
