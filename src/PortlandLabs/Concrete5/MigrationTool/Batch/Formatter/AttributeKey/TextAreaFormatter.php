<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TextAreaFormatter extends AbstractFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Mode');
        $node->itemvalue = $this->key->getMode();

        return $this->deliverTreeNodeDataJsonObject(array($node));
    }
}
