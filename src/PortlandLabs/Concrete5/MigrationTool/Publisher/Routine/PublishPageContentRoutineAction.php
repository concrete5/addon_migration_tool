<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Type\Composer\FormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PublishPageContentRoutineAction extends AbstractPageAction
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $page = $this->page;
        $concretePage = $this->getPageByPath($batch, $page->getBatchPath());

        foreach ($page->attributes as $attribute) {
            $ak = $this->getTargetItem($batch, 'page_attribute', $attribute->getAttribute()->getHandle());
            if (is_object($ak)) {
                $logger->logPublishStarted($attribute);
                $value = $attribute->getAttribute()->getAttributeValue();
                $publisher = $value->getPublisher();
                $publisher->publish($batch, $ak, $concretePage, $value);
                $logger->logPublishComplete($attribute);
            }
        }

        $em = \Package::getByHandle('migration_tool')->getEntityManager();
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem');
        $controls = $r->findBy(array('item_type' => 'composer_output_content'));
        $controlHandles = array_map(function ($a) {
            return $a->getItemID();
        }, $controls);
        $blockSubstitutes = array();
        // Now we have our $controls array which we will use to determine if any of the blocks on this page
        // need to be replaced by another block.

        foreach ($page->areas as $area) {
            $areaName = $this->getTargetItem($batch, 'area', $area->getName());
            $styleSet = $area->getStyleSet();
            if ($areaName) {
                if (is_object($styleSet)) {
                    $styleSetPublisher = $styleSet->getPublisher();
                    $publishedStyleSet = $styleSetPublisher->publish();
                    $concreteArea = \Area::getOrCreate($concretePage, $areaName);
                    $concretePage->setCustomStyleSet($concreteArea, $publishedStyleSet);
                }
                foreach ($area->blocks as $block) {
                    $bt = $this->getTargetItem($batch, 'block_type', $block->getType());
                    if (is_object($bt)) {
                        $logger->logPublishStarted($block);
                        $value = $block->getBlockValue();
                        $publisher = $value->getPublisher();
                        $b = $publisher->publish($batch, $bt, $concretePage, $areaName, $value);
                        $logger->logPublishComplete($block, $b);
                        $styleSet = $block->getStyleSet();
                        if (is_object($styleSet)) {
                            $styleSetPublisher = $styleSet->getPublisher();
                            $publishedStyleSet = $styleSetPublisher->publish();
                            $b->setCustomStyleSet($publishedStyleSet);
                        }
                        if ($block->getCustomTemplate()) {
                            $b->setCustomTemplate($block->getCustomTemplate());
                        }

                        if (in_array($bt->getBlockTypeHandle(), $controlHandles)) {
                            $blockSubstitutes[$bt->getBlockTypeHandle()] = $b;
                        }
                    }
                }
            }
        }

        // Loop through all the blocks on the page. If any of them are composer output content blocks
        // We look in our composer mapping.
        foreach ($concretePage->getBlocks() as $b) {
            if ($b->getBlockTypeHandle() == BLOCK_HANDLE_PAGE_TYPE_OUTPUT_PROXY) {
                foreach ($controls as $targetItem) {
                    if ($targetItem->isMapped() && intval($targetItem->getSourceItemIdentifier()) == intval($b->getBlockID())) {
                        $substitute = $blockSubstitutes[$targetItem->getItemID()];
                        if ($substitute) {
                            // We move the substitute to where the proxy block was.
                            $blockDisplayOrder = $b->getBlockDisplayOrder();
                            $substitute->setAbsoluteBlockDisplayOrder($blockDisplayOrder);
                            $control = $b->getController()->getComposerOutputControlObject();
                            if (is_object($control)) {
                                $control = FormLayoutSetControl::getByID($control->getPageTypeComposerFormLayoutSetControlID());
                                if (is_object($control)) {
                                    $blockControl = $control->getPageTypeComposerControlObject();
                                    if (is_object($blockControl)) {
                                        $blockControl->recordPageTypeComposerOutputBlock($substitute);
                                    }
                                }
                            }
                        }
                    }
                }
                // we delete the proxy block
                $b->deleteBlock();
            }
        }
    }
}
