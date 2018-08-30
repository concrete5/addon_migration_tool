<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Type\Type;
use Concrete\Core\Utility\Service\Text;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractPageAction implements RoutineActionInterface
{
    protected $page;
    protected $page_id;

    public function __construct($page) // can't type hint, might be a stack. probably should have an interface.
    {
        $this->page = $page;
        $this->page_id = $page->getID();
    }

    public function __sleep()
    {
        return array('page_id');
    }

    public function __wakeup()
    {
        $this->populatePageObject($this->page_id);
    }

    protected function getPageByPath(Batch $batch, $path)
    {
        return \Page::getByPath('/!import_batches/' . $batch->getID() . $path,
            'RECENT',
            $batch->getSite()->getSiteTreeObject()
        );
    }

    public function populatePageObject($id)
    {
        $entityManager = \Database::connection()->getEntityManager();
        $r = $entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
        $this->page = $r->findOneById($id);
    }

    protected function ensureParentPageExists(Batch $batch, Page $page)
    {
        $service = new Text();
        $path = trim($page->getBatchPath(), '/');
        $paths = explode('/', $path);
        $batchParent = $this->getBatchParentPage($batch);
        $parent = $batchParent;
        $prefix = '';

        array_pop($paths);

        foreach($paths as $path) {
            $currentPath = $prefix . $path;
            $c = \Concrete\Core\Page\Page::getByPath($batchParent->getCollectionPath() . '/' . $currentPath, 'RECENT', $batch->getSite()->getSiteTreeObject());
            if ($c->isError() && $c->getError() == COLLECTION_NOT_FOUND) {
                $data = array();
                $data['handle'] = $path;
                $data['name'] = $service->unhandle($data['handle']);
                $data['uID'] = USER_SUPER_ID;
                $parent = $parent->add(null, $data);
            } else {
                $parent = $c;
            }
            $prefix = $currentPath . '/';
        }
        return $parent;
    }

    public function getTargetItem($batch, $mapper, $subject)
    {
        return TargetItemList::getBatchTargetItem($batch, $mapper, $subject);
    }

    protected function getBatchParentPage(BatchInterface $batch)
    {
        $page = \Page::getByPath('/!import_batches/' . $batch->getID(), 'RECENT', $batch->getSite()->getSiteTreeObject());
        if (is_object($page) && !$page->isError()) {
            return $page;
        } else {
            return $this->addBatchParent($batch);
        }
    }

    protected function addBatchParent(BatchInterface $batch)
    {
        $holder = \Page::getByPath('/!import_batches', 'RECENT', $batch->getSite()->getSiteTreeObject());
        $type = Type::getByHandle('import_batch');
        return $holder->add($type, array(
            'cName' => $batch->getID(),
            'pkgID' => \Package::getByHandle('migration_tool')->getPackageID(),
        ));

    }
}
