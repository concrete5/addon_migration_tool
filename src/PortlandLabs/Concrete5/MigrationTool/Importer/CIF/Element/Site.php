<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SiteAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\SiteObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Site implements ElementParserInterface
{

    protected $attributeImporter;

    public function __construct()
    {
        $this->attributeImporter = \Core::make('migration/manager/import/attribute/value');
    }

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new SiteObjectCollection();
        if ($element->sites->site) {
            foreach ($element->sites->site as $node) {
                $site = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Site();
                $site->setHandle((string) $node['handle']);
                $site->setName((string) $node['name']);
                $site->setType((string) $node['type']);
                $site->setCanonicalUrl((string) $node['canonical-url']);

                // Parse attributes
                if ($node->attributes->attributekey) {
                    $i = 0;
                    foreach ($node->attributes->attributekey as $keyNode) {

                        $attribute = new Attribute();
                        $attribute->setHandle((string) $keyNode['handle']);
                        $value = $this->attributeImporter->driver()->parse($keyNode);
                        $attribute->setAttributeValue($value);

                        $siteAttribute = new SiteAttribute();
                        $siteAttribute->setAttribute($attribute);
                        $siteAttribute->setSite($site);
                        $site->attributes->add($siteAttribute);
                        ++$i;
                    }
                }

                $collection->getSites()->add($site);
                $site->setCollection($collection);
            }
        }

        return $collection;
    }
}
