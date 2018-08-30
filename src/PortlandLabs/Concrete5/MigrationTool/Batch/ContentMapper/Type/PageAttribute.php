<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\TransformableEntityMapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\ShortDescriptionTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CollectionAttributeComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageAttribute extends Attribute
{

    public function getAttributeKeyCategoryHandle()
    {
        return 'collection';
    }

    public function getMappedItemPluralName()
    {
        return t('Page Attributes');
    }

    public function getHandle()
    {
        return 'page_attribute';
    }

    public function getTransformableEntityObjects(BatchInterface $batch)
    {
        $attributes = array();
        foreach ($batch->getPages() as $page) {
            foreach ($page->getAttributes() as $attribute) {
                if (is_object($attribute->getAttribute())) {
                    $attributes[] = $attribute->getAttribute();
                }
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $type) {
                $defaults = $type->getDefaultPageCollection();
                foreach ($defaults->getPages() as $page) {
                    foreach ($page->getAttributes() as $attribute) {
                        if (is_object($attribute->getAttribute())) {
                            $attributes[] = $attribute->getAttribute();
                        }
                    }
                }
            }
        }

        return $attributes;
    }

    public function getAttributeItemHandles(BatchInterface $batch)
    {
        $handles = parent::getAttributeItemHandles($batch);

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $type) {
                foreach ($type->getLayoutSets() as $set) {
                    foreach ($set->getControls() as $control) {
                        if ($control instanceof CollectionAttributeComposerFormLayoutSetControl) {
                            if (!in_array($control->getItemIdentifier(), $handles)) {
                                $handles[] = $control->getItemIdentifier();
                            }
                        }
                    }
                }
            }
        }

        return $handles;
    }

    public function getCorePropertyTargetItems(BatchInterface $batch)
    {
        $items = array(new ShortDescriptionTargetItem($this));

        return $items;
    }

}
