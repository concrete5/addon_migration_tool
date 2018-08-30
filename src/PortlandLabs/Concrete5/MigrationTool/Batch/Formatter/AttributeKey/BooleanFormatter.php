<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class BooleanFormatter extends AbstractFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Checked');
        $node->itemvalue = $this->key->getIsChecked() ? t('Yes') : t('No');

        return $this->deliverTreeNodeDataJsonObject(array($node));
    }
}
