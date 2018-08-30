<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThumbnailTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ThumbnailType implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new ThumbnailTypeObjectCollection();
        if ($element->thumbnailtypes->thumbnailtype) {
            foreach ($element->thumbnailtypes->thumbnailtype as $node) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ThumbnailType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setWidth(intval((string) $node['width']));
                $type->setHeight(intval((string) $node['height']));
                $required = (string) $node['required'];
                if ($required) {
                    $type->setIsRequired(true);
                }
                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }

        return $collection;
    }
}
