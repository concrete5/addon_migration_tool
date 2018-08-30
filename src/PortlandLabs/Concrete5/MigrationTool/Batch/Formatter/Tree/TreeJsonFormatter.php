<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Tree;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AbstractTreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\TreeNode;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter extends AbstractTreeJsonFormatter
{
    protected function addChildNode(\stdClass $parent, TreeNode $n)
    {
        $node = new \stdClass();
        $node->title = $n->getTitle();
        foreach ($n->getChildren() as $child) {
            $this->addChildNode($node, $child);
        }
        $parent->children[] = $node;
    }

    public function jsonSerialize()
    {
        $response = array();
        foreach ($this->collection->getTrees() as $tree) {
            $node = new \stdClass();
            $node->title = $tree->getName();
            $node->nodetype = 'tree';
            $node->extraClasses = 'migration-node-main';
            $node->id = $tree->getId();
            foreach ($tree->getRootNodes() as $n) {
                $this->addChildNode($node, $n);
            }
            $response[] = $node;
        }

        return $response;
    }
}
