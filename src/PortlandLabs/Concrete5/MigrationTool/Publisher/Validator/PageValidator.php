<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\CreatePageStructureRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\CreatePageStructureRoutineAction;

class PageValidator extends AbstractValidator
{

    protected $skip = false;

    public function __construct(PublishableInterface $object)
    {
        parent::__construct($object);

        $em = \Database::connection()->getEntityManager();
        $page = $this->object;
        /**
         * @var $page Page
         */
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $collection = $page->getCollection();
        $batch = $r->findFromCollection($collection);

        // This code checks to see if the page type for the current page is being ignored globally.
        // If it is, then we ignore this page.
        $mappers = \Core::make('migration/manager/mapping');
        $mapper = $mappers->driver('page_type');
        $list = $mappers->createTargetItemList($batch, $mapper);
        $item = new Item($page->getType());
        $targetItem = $list->getSelectedTargetItem($item);

        if ($targetItem instanceof IgnoredTargetItem) {
            $this->skip = true;
        }

    }

    public function skipItem()
    {
        return $this->skip;
    }
}
