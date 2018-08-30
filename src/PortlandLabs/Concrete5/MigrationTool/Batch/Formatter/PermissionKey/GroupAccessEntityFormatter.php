<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey;

defined('C5_EXECUTE') or die("Access Denied.");

class GroupAccessEntityFormatter extends AccessEntityFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Group');
        $node->itemvalue = $this->entity->getGroupName();

        return $node;
    }
}
