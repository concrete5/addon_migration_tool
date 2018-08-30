<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractPageRoutine implements RoutineInterface
{
    protected $batch;

    abstract public function getPageRoutineAction($page);

    /**
     * @return mixed
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param mixed $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }

    public function getPageCollection(BatchInterface $batch)
    {
        return $batch->getObjectCollection('page');
    }

    public function getPages(ObjectCollection $collection)
    {
        return $collection->getPages();
    }

    public function getPagesOrderedForImport(Batch $batch)
    {
        $collection = $this->getPageCollection($batch);

        if (!$collection) {
            return array();
        }

        $pages = array();
        foreach ($this->getPages($collection) as $page) {
            $pages[] = $page;
        }
        usort($pages, function ($pageA, $pageB) {
            $pathA = (string) $pageA->getBatchPath();
            $pathB = (string) $pageB->getBatchPath();
            $numA = count(explode('/', $pathA));
            $numB = count(explode('/', $pathB));
            if ($numA == $numB) {
                if (intval($pageA->getPosition()) < intval($pageB->getPosition())) {
                    return -1;
                } else {
                    if (intval($pageA->getPosition()) > intval($pageB->getPosition())) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            } else {
                return ($numA < $numB) ? -1 : 1;
            }
        });

        return $pages;
    }

    public function getPublisherRoutineActions(BatchInterface $batch)
    {
        $pages = $this->getPagesOrderedForImport($batch);

        if (!$pages) {
            return array();
        }

        // Now loop through all pages, and build them
        $actions = array();
        foreach ($pages as $page) {
            if (!$page->getPublisherValidator()->skipItem()) {
                $action = $this->getPageRoutineAction($page);
                $actions[] = $action;
            }
        }

        return $actions;
    }
}
