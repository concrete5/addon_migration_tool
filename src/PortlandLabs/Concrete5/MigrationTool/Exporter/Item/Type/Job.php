<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class Job extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('jobs');
        foreach ($collection->getItems() as $type) {
            $j = \Concrete\Core\Job\Job::getByID($type->getItemIdentifier());
            if (is_object($j)) {
                $nodeType = $node->addChild('job');
                $nodeType->addAttribute('handle', $j->getJobHandle());
                $nodeType->addAttribute('package', $j->getPackageHandle());
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $j = \Concrete\Core\Job\Job::getByID($exportItem->getItemIdentifier());

        return array($j->getJobName());
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $j = \Concrete\Core\Job\Job::getByID($id);
            if (is_object($j)) {
                $job = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Job();
                $job->setItemId($j->getJobID());
                $items[] = $job;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = \Concrete\Core\Job\Job::getList();
        $items = array();
        foreach ($list as $j) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Job();
            $item->setItemId($j->getJobID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'job';
    }

    public function getPluralDisplayName()
    {
        return t('Jobs');
    }
}
