<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType;

defined('C5_EXECUTE') or die("Access Denied.");

class AllPagesPublishTargetFormatter extends PublishTargetFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        return $this->deliverTreeNodeDataJsonObject();
    }

    public function getTreeNodeTitle()
    {
        return t('All Pages');
    }
}
