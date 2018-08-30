<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Block\BlockType\BlockTypeList;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\BlockComposerFormLayoutSetControl;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockType implements MapperInterface, TransformableEntityMapperInterface
{

    protected $predefinedMappers = [
        'slideshow' => 'image_slider',
    ];

    public function getMappedItemPluralName()
    {
        return t('Block Types');
    }

    public function getHandle()
    {
        return 'block_type';
    }

    public function getTransformableEntityObjects(BatchInterface $batch)
    {
        $blocks = array();
        foreach ($batch->getPages() as $page) {
            foreach ($page->getAreas() as $area) {
                foreach ($area->getBlocks() as $block) {
                    $blocks[] = $block;
                    $blockValue = $block->getBlockValue();
                    if ($blockValue instanceof AreaLayoutBlockValue) {
                        // UPDATE: We DO have a way to do this. We need to implement BlockProviderInterface
                        // The same way the user mapper has created a new collection based userproviderinterface.
                        // it works really well to specify what content types provide users. We need to roll it out to all
                        // other mappers.

                        // Note: we REALLY need a way to publish new provider drivers
                        // so that area layout, stack, page type, etc.. can all say they provide
                        // block types, and this routine is a bloated, procedural mess.
                        $columns = $blockValue->getAreaLayout()->getColumns();
                        foreach ($columns as $column) {
                            $columnBlocks = $column->getBlocks();
                            foreach ($columnBlocks as $columnBlock) {
                                $blocks[] = $columnBlock;
                            }
                        }
                    }
                }
            }
        }
        $stacks = $batch->getObjectCollection('stack');
        if (is_object($stacks)) {
            foreach ($stacks->getStacks() as $stack) {
                $stackBlocks = $stack->getBlocks();
                foreach ($stackBlocks as $block) {
                    $blocks[] = $block;
                }
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $type) {
                $defaults = $type->getDefaultPageCollection();
                foreach ($defaults->getPages() as $page) {
                    foreach ($page->getAreas() as $area) {
                        foreach ($area->getBlocks() as $block) {
                            $blocks[] = $block;
                        }
                    }
                }
            }
        }

        return $blocks;
    }

    public function getItems(BatchInterface $batch)
    {
        $types = array();
        $blocks = $this->getTransformableEntityObjects($batch);
        foreach ($blocks as $block) {
            if ($block->getType() && !in_array($block->getType(), $types)) {
                $types[] = $block->getType();
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $type) {
                foreach ($type->getLayoutSets() as $set) {
                    foreach ($set->getControls() as $control) {
                        if ($control instanceof BlockComposerFormLayoutSetControl) {
                            if (!in_array($control->getItemIdentifier(), $types)) {
                                $types[] = $control->getItemIdentifier();
                            }
                        }
                    }
                }
            }
        }

        $items = array();
        foreach ($types as $type) {
            $item = new Item($type);
            $items[] = $item;
        }

        return $items;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        $bt = \Concrete\Core\Block\BlockType\BlockType::getByHandle($item->getIdentifier());
        if (!$bt) {
            if (array_key_exists($item->getIdentifier(), $this->predefinedMappers)) {
                $bt = \Concrete\Core\Block\BlockType\BlockType::getByHandle($this->predefinedMappers[$item->getIdentifier()]);
            }
        }

        if ($bt) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($bt->getBlockTypeHandle());
            $targetItem->setItemName($bt->getBlockTypeName());
            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('block_type');
            if (is_object($collection)) {
                foreach ($collection->getTypes() as $type) {
                    if ($type->getHandle() == $item->getIdentifier()) {
                        $targetItem = new TargetItem($this);
                        $targetItem->setItemId($type->getHandle());
                        $targetItem->setItemName($type->getHandle());

                        return $targetItem;
                    }
                }
            }
        }
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $list = new BlockTypeList();
        $list->includeInternalBlockTypes();
        $types = $list->get();
        usort($types, function ($a, $b) {
            return strcasecmp($a->getBlockTypeName(), $b->getBlockTypeName());
        });
        $items = array();
        foreach ($types as $type) {
            $item = new TargetItem($this);
            $item->setItemId($type->getBlockTypeHandle());
            $item->setItemName($type->getBlockTypeName());
            $items[] = $item;
        }

        return $items;
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        $collection = $batch->getObjectCollection('block_type');
        $items = array();
        if ($collection) {
            foreach ($collection->getTypes() as $type) {
                if (!$type->getPublisherValidator()->skipItem()) {
                    $item = new TargetItem($this);
                    $item->setItemId($type->getHandle());
                    $item->setItemName($type->getHandle());
                    $items[] = $item;
                }
            }
        }

        return $items;
    }

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return \Concrete\Core\Block\BlockType\BlockType::getByHandle($targetItem->getItemID());
    }
}
