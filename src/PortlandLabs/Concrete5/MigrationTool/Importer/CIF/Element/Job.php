<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\JobObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Job implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new JobObjectCollection();
        if ($element->jobs->job) {
            foreach ($element->jobs->job as $node) {
                $job = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Job();
                $job->setHandle((string) $node['handle']);
                $job->setPackage((string) $node['package']);
                $collection->getJobs()->add($job);
                $job->setCollection($collection);
            }
        }

        return $collection;
    }
}
