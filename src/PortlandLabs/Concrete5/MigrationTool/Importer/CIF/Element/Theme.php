<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThemeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Theme implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new ThemeObjectCollection();
        if ($element->themes->theme) {
            foreach ($element->themes->theme as $node) {
                $theme = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Theme();
                $theme->setHandle((string) $node['handle']);
                $theme->setPackage((string) $node['package']);
                $theme->setIsActivated((string) $node['activated']);
                $collection->getThemes()->add($theme);
                $theme->setCollection($collection);
            }
        }

        return $collection;
    }
}
