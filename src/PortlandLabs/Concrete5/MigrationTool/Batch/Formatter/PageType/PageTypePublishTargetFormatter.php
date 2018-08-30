<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypePublishTargetFormatter extends PublishTargetFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = $this->entity->getPageType();

        return $this->deliverTreeNodeDataJsonObject(array($node));
    }

    public function getTreeNodeTitle()
    {
        return t('Page Type');
    }
}
