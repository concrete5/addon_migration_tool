<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\TreeNode;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\TreeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\Type;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Tree implements ElementParserInterface
{
    protected function walk(\SimpleXMLElement $node,
    \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Tree $tree,
    TreeNode $parent = null)
    {
        foreach ($node->children() as $child) {
            $n = new TreeNode();
            $n->setType((string) $child->getName());
            $n->setTitle((string) $child['name']);
            $n->setTree($tree);
            $n->setParent($parent);
            if ($child->count() > 0) {
                $this->walk($child, $tree, $n);
            }
            $tree->getNodes()->add($n);
        }
    }

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new TreeObjectCollection();
        if ($element->trees->tree) {
            foreach ($element->trees->tree as $node) {
                $tree = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Tree();
                $tree->setType((string) $node['type']);
                $tree->setName((string) $node['name']);
                $this->walk($node, $tree);
                $collection->getTrees()->add($tree);
                $tree->setCollection($collection);
            }
        }

        return $collection;
    }
}
