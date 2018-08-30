<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackBlock;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Stack implements ElementParserInterface
{
    protected $blockImporter;

    public function __construct()
    {
        $this->blockImporter = \Core::make('migration/manager/import/cif_block');
    }

    protected function parseStack(\SimpleXMLElement $element)
    {
        if ($element->getName() == 'folder') {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackFolder();
        } elseif ((string) $element['type'] == 'global_area') {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\GlobalArea();
        } else {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Stack();
        }
        $item->setName((string) $element['name']);
        $item->setPath((string) $element['path']);

        return $item;
    }

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $collection = new StackObjectCollection();
        if ($element->stacks) {
            $position = 0;
            foreach ($element->stacks->children() as $node) {
                $stack = $this->parseStack($node);
                $stack->setPosition($position);
                if ($node->area->blocks->block) {
                    $blocks = $node->area->blocks->block;
                } elseif ($node->area->block) { // 5.6
                    $blocks = $node->area->block;
                }
                if (isset($blocks)) {
                    $i = 0;
                    foreach ($blocks as $blockNode) {
                        if ($blockNode['type']) {
                            $block = new StackBlock();
                            $block->setType((string) $blockNode['type']);
                            $block->setName((string) $blockNode['name']);
                            $bFilename = (string) $blockNode['custom-template'];
                            if ($bFilename) {
                                $block->setCustomTemplate($bFilename);
                            }
                            $value = $this->blockImporter->driver('unmapped')->parse($blockNode);
                            if (isset($blockNode->style)) {
                                $styleSet = $this->styleSetImporter->import($blockNode->style);
                                $block->setStyleSet($styleSet);
                            }
                            $block->setBlockValue($value);
                            $block->setPosition($i);
                            $block->setStack($stack);
                            $stack->getBlocks()->add($block);
                            ++$i;
                        }
                    }
                }
                ++$position;
                $collection->getStacks()->add($stack);
                $stack->setCollection($collection);
            }
        }

        return $collection;
    }
}
