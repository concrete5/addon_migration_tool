<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type;

use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\ItemInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTemplate implements MapperInterface
{
    public function getMappedItemPluralName()
    {
        return t('Page Templates');
    }

    public function getHandle()
    {
        return 'page_template';
    }

    public function getItems(BatchInterface $batch)
    {
        $templates = array();
        foreach ($batch->getPages() as $page) {
            if ($page->getTemplate() && !in_array($page->getTemplate(), $templates)) {
                $templates[] = $page->getTemplate();
            }
        }

        $pageTemplates = $batch->getObjectCollection('page_template');
        if (is_object($pageTemplates)) {
            foreach ($pageTemplates->getTemplates() as $pageTemplate) {
                if (!in_array($pageTemplate->getHandle(), $templates)) {
                    $templates[] = $pageTemplate->getHandle();
                }
            }
        }

        $pageTypes = $batch->getObjectCollection('page_type');
        if (is_object($pageTypes)) {
            foreach ($pageTypes->getTypes() as $pageType) {
                if ($template = $pageType->getDefaultTemplate()) {
                    if (!in_array($template, $templates)) {
                        $templates[] = $template;
                    }
                }
                if ($pageType->getAllowedTemplates() == 'C') {
                    foreach ($pageType->getTemplates() as $template) {
                        if (!in_array($template, $templates)) {
                            $templates[] = $template;
                        }
                    }
                }
            }
        }

        $items = array();
        foreach ($templates as $template) {
            $item = new Item();
            $item->setIdentifier($template);
            $items[] = $item;
        }

        return $items;
    }

    public function getMatchedTargetItem(BatchInterface $batch, ItemInterface $item)
    {
        $template = Template::getByHandle($item->getIdentifier());
        if (is_object($template)) {
            $targetItem = new TargetItem($this);
            $targetItem->setItemId($template->getPageTemplateHandle());
            $targetItem->setItemName($template->getPageTemplateName());

            return $targetItem;
        } else { // we check the current batch.
            $collection = $batch->getObjectCollection('page_template');
            if (is_object($collection)) {
                foreach ($collection->getTemplates() as $template) {
                    if ($template->getHandle() == $item->getIdentifier()) {
                        $targetItem = new TargetItem($this);
                        $targetItem->setItemId($template->getHandle());
                        $targetItem->setItemName($template->getName());

                        return $targetItem;
                    }
                }
            }
        }
    }

    public function getBatchTargetItems(BatchInterface $batch)
    {
        $collection = $batch->getObjectCollection('page_template');
        $items = array();
        if ($collection) {
            foreach ($collection->getTemplates() as $template) {
                if (!$template->getPublisherValidator()->skipItem()) {
                    $item = new TargetItem($this);
                    $item->setItemId($template->getHandle());
                    $item->setItemName($template->getName());
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

    public function getInstalledTargetItems(BatchInterface $batch)
    {
        $templates = Template::getList();
        usort($templates, function ($a, $b) {
            return strcasecmp($a->getPageTemplateName(), $b->getPageTemplateName());
        });
        $items = array();
        foreach ($templates as $template) {
            $item = new TargetItem($this);
            $item->setItemId($template->getPageTemplateHandle());
            $item->setItemName($template->getPageTemplateName());
            $items[] = $item;
        }

        return $items;
    }

    public function getTargetItemContentObject(TargetItemInterface $targetItem)
    {
        return Template::getByHandle($targetItem->getItemID());
    }
}
