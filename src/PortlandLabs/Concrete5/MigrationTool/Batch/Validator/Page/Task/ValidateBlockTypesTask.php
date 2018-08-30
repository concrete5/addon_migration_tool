<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use Concrete\Core\Page\Type\Type;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\BlockItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateBlockTypesTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        $blocks = $action->getSubject();
        $target = $action->getTarget();
        $mapper = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType();
        $targetItemList = new TargetItemList($target->getBatch(), $mapper);
        foreach ($blocks as $block) {
            if ($block->getType()) {
                $item = new BlockItem($block);
                $targetItem = $targetItemList->getSelectedTargetItem($item);
                if ($targetItem instanceof UnmappedTargetItem) {
                    $action->getTarget()->addMessage(
                        new Message(t('Block type <strong>%s</strong> does not exist.', $item->getIdentifier()))
                    );
                }
            } elseif ($block->getDefaultsOutputIdentifier()) {
                // This is a block on a page that is pulling its content from page defaults. We need to find
                // a block with the corresponding string in page defaults. Otherwise we're going to have a problem.
                $area = $block->getArea();
                $found = false;
                if (is_object($area)) {
                    $page = $area->getPage();
                    if (is_object($page)) {
                        $type = $page->getType();
                        $template = $page->getTemplate();
                        if ($type && $template) {
                            // Retrieve the page  type by handle.
                            $em = \Package::getByHandle('migration_tool')->getEntityManager();
                            $r1 = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType');
                            $pageType = $r1->findOneByHandle($type);
                            if (is_object($pageType)) {
                                $defaults = $pageType->getDefaultPageCollection();
                                foreach ($defaults->getPages() as $default) {
                                    if ($default->getTemplate() == $template) {
                                        // whew. We've located the proper place.
                                        foreach ($default->getAreas() as $area) {
                                            foreach ($area->getBlocks() as $defaultBlock) {
                                                if ($defaultBlock->getDefaultsOutputIdentifier() == $block->getDefaultsOutputIdentifier()) {
                                                    $found = true;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (!$found) {
                    $action->getTarget()->addMessage(
                        new Message(t('Page Type Defaults Output Reference <strong>%s</strong> not found within corresponding defaults.', $block->getDefaultsOutputIdentifier()))
                    );
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
