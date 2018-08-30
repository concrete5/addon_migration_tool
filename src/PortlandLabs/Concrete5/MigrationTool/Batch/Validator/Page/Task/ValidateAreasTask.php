<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidateAreasTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        // Grab the target item for the page's page type.
        $subject = $action->getSubject();
        $target = $action->getTarget();
        $areaMapper = new Area();
        $targetItemList = new TargetItemList($target->getBatch(), $areaMapper);
        foreach ($subject->getAreas() as $area) {
            $item = new Item($area->getName());
            $targetItem = $targetItemList->getSelectedTargetItem($item);
            if ($targetItem instanceof UnmappedTargetItem) {
                $template = $subject->getTemplate();
                // Now, if the page template exists in the batch, there's a chance that the reason the area
                // doesn't exist in the site is because it's part of the new template. In that case, we should show
                // an info message so we don't get as many scary red errors.
                if ($template) {
                    $em = \Package::getByHandle('migration_tool')->getEntityManager();
                    $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate');
                    $batchTemplate = $r->findOneByHandle($template);
                }

                if (isset($batchTemplate) && is_object($batchTemplate)) {
                    $action->getTarget()->addMessage(
                        new Message(t('Area <strong>%s</strong> does not exist in site. If this area is in a new page template this message can be disregarded.', $item->getIdentifier()), Message::E_INFO)
                    );
                } else {
                    $action->getTarget()->addMessage(
                        new Message(t('Area <strong>%s</strong> does not exist.', $item->getIdentifier()))
                    );
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
