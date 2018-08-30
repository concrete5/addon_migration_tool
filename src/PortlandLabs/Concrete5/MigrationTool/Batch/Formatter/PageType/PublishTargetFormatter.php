<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PublishTarget;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class PublishTargetFormatter implements TreeContentItemFormatterInterface
{
    protected $entity;

    abstract public function getTreeNodeTitle();

    public function __construct(PublishTarget $entity)
    {
        $this->entity = $entity;
    }

    protected function deliverTreeNodeDataJsonObject($children = array())
    {
        $node2 = new \stdClass();
        $node2->title = $this->getTreeNodeTitle();
        $node2->icon = 'fa fa-share-alt';
        $node2->children = $children;

        $node1 = new \stdClass();
        $node1->title = t('Publish Target');
        $node1->icon = 'fa fa-database';
        $node1->children = array($node2);

        return $node1;
    }
}
