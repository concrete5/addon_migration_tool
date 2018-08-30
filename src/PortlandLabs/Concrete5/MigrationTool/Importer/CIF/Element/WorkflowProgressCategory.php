<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\ProgressCategory;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Workflow\ProgressCategoryObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class WorkflowProgressCategory implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new ProgressCategoryObjectCollection();
        if ($element->workflowprogresscategories->category) {
            foreach ($element->workflowprogresscategories->category as $node) {
                $category = new ProgressCategory();
                $category->setHandle((string) $node['handle']);
                $category->setPackage((string) $node['package']);
                $collection->getCategories()->add($category);
                $category->setCollection($collection);
            }
        }

        return $collection;
    }
}
