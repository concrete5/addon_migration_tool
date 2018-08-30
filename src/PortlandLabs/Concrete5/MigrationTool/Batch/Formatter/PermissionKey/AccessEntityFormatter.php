<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class AccessEntityFormatter implements TreeContentItemFormatterInterface
{
    protected $entity;

    public function __construct(AccessEntity $entity)
    {
        $this->entity = $entity;
    }

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Entity');
        $node->itemvalue = $this->entity->getEntityType();

        return $node;
    }
}
