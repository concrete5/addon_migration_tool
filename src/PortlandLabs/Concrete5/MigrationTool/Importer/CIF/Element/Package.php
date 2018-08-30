<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PackageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Package implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new PackageObjectCollection();
        if ($element->packages->package) {
            foreach ($element->packages->package as $node) {
                $pkg = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Package();
                $pkg->setHandle((string) $node['handle']);
                $collection->getPackages()->add($pkg);
                $pkg->setCollection($collection);
            }
        }

        return $collection;
    }
}
