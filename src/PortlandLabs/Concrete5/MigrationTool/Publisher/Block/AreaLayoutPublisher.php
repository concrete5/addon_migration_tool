<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use Concrete\Core\Area\SubArea;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use Concrete\Core\Area\Area as CoreArea;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\PublisherInterface as BlockPublisherInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\PublishPageContentRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\PublishPageContentRoutineAction;

defined('C5_EXECUTE') or die("Access Denied.");

class AreaLayoutPublisher implements PublisherInterface
{
    public function publish(Batch $batch, $bt, Page $page, $area, BlockValue $value)
    {
        /* @var $value AreaLayoutBlockValue */
        $layout = $value->getAreaLayout();
        $publisher = $layout->getPublisher();
        $layoutObject = $publisher->publish($layout);
        $columns = $layout->getColumns();
        $i = 0;
        $layoutBlock = $page->addBlock($bt, $area, array('arLayoutID' => $layoutObject->getAreaLayoutID()));
        foreach ($layoutObject->getAreaLayoutColumns() as $columnObject) {
            $column = $columns[$i];
            foreach ($column->getBlocks() as $block) {
                $subValue = $block->getBlockValue();
                $publisher = $subValue->getPublisher();
                $subAreaName = $area . SubArea::AREA_SUB_DELIMITER . $columnObject->getAreaLayoutColumnDisplayID();
                $subarea = new CoreArea($subAreaName);

                /*
                 * @var $publisher BlockPublisherInterface
                 */
                $subBlockType = TargetItemList::getBatchTargetItem($batch, 'block_type', $block->getType());
                if (is_object($subBlockType)) {
                    $b = $publisher->publish($batch, $subBlockType, $page, $subarea, $subValue);
                    $styleSet = $block->getStyleSet();
                    if (is_object($styleSet)) {
                        $styleSetPublisher = $styleSet->getPublisher();
                        $publishedStyleSet = $styleSetPublisher->publish();
                        $b->setCustomStyleSet($publishedStyleSet);
                    }
                    if ($block->getCustomTemplate()) {
                        $b->setCustomTemplate($block->getCustomTemplate());
                    }
                }
            }
            ++$i;
        }

        return $layoutBlock;
    }
}
