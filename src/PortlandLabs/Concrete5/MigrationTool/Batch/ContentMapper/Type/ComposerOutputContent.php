<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ComposerOutputContentItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ComposerOutputContent implements MapperInterface
{
    public function getMappedItemPluralName()
    {
        return t('Composer Content');
    }

    public function getHandle()
    {
        return 'composer_output_content';
    }

    public function getPageTypeComposerOutputContentItems(Type $type)
    {
        $items = array();
        foreach ($type->getPageTypePageTemplateObjects() as $template) {
            $c = $type->getPageTypePageTemplateDefaultPageObject($template);
            $blocks = $c->getBlocks();
            foreach ($blocks as $b) {
                if ($b->getBlockTypeHandle() == BLOCK_HANDLE_PAGE_TYPE_OUTPUT_PROXY) {
                    $item = new ComposerOutputContentItem($b);
                    if ($item->getBlock()) {
                        $items[] = $item;
                    }
                }
            }
        }

        return $items;
    }

    public function getItems(BatchInterface $batch)
    {
        // first, loop through all the page types
        // that are mapped in the current content batch
        $em = \Package::getByHandle('migration_tool')->getEntityManager();
        $query = $em->createQuery(
            "select ti from PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem bti
            join PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem ti
            where bti.batch = :batch and bti.target_item = ti and ti.item_type = :type"
        );
        $query->setParameter('batch', $batch);
        $query->setParameter('type', 'page_type');
        $types = $query->getResult();

        $items = array();
        $handles = array();
        foreach ($types as $type) {
            if (!in_array($type->getItemID(), $handles)) {
                $handles[] = $type->getItemID();
            }
        }
        foreach ($handles as $handle) {
            $type = Type::getByHandle($handle);
            if (is_object($type)) {
                $items = array_merge($items, $this->getPageTypeComposerOutputContentItems($type));
            }
        }

        return $items;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        return false;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return false;
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        return array();
    }

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $em = \Package::getByHandle('migration_tool')->getEntityManager();
        $query = $em->createQuery('select distinct b from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block b
        group by b.type order by b.type asc');
        $types = $query->getResult();
        $items = array();
        foreach ($types as $type) {
            $item = new TargetItem($this);
            $item->setItemId($type->getType());
            $item->setItemName($type->getType());
            $items[] = $item;
        }

        return $items;
    }
}
