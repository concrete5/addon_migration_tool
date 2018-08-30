<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SocialLinkObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLink implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new SocialLinkObjectCollection();
        if ($element->sociallinks->link) {
            foreach ($element->sociallinks->link as $node) {
                $link = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\SocialLink();
                $link->setService((string) $node['service']);
                $link->setUrl((string) $node['url']);
                $collection->getLinks()->add($link);
                $link->setCollection($collection);
            }
        }

        return $collection;
    }
}
