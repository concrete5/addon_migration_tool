<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\AssociatedEntry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAssociation;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control\Manager;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntry implements ElementParserInterface
{

    public function __construct()
    {
        $this->attributeImporter = \Core::make('migration/manager/import/attribute/value');
    }

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new EntryObjectCollection();
        if ($element->expressentries->entry) {
            foreach ($element->expressentries->entry as $node) {
                $entry = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry();
                $entry->setDisplayOrder((string) $node['display-order']);
                $entry->setImportID((string) $node['id']);
                $entry->setLabel((string) $node['label']);
                $entry->setEntity((string) $node['entity']);
                $this->parseAttributes($entry, $node);
                $this->parseAssociations($entry, $node);
                $collection->getEntries()->add($entry);
                $entry->setCollection($collection);
            }
        }
        return $collection;
    }

    protected function parseAttributes(\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry $entry, \SimpleXMLElement $node)
    {
        if ($node->attributes->attributekey) {
            $i = 0;
            foreach ($node->attributes->attributekey as $keyNode) {
                $attribute = $this->parseAttribute($keyNode);
                $entryAttribute = new EntryAttribute();
                $entryAttribute->setAttribute($attribute);
                $entryAttribute->setEntry($entry);
                $entry->getAttributes()->add($entryAttribute);
                ++$i;
            }
        }
    }

    protected function parseAssociations(\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry $entry, \SimpleXMLElement $node)
    {
        if ($node->associations->association) {
            $i = 0;
            foreach ($node->associations->association as $associationNode) {
                $association = new EntryAssociation();
                $association->setTarget((string) $associationNode['target']);
                if (isset($associationNode->entries)) {
                    foreach($associationNode->entries->entry as $entryNode) {
                        $associatedEntry = new AssociatedEntry();
                        $associatedEntry->setImportID((string) $entryNode['entry']);
                        $associatedEntry->setAssociation($association);
                        $association->getAssociatedEntries()->add($associatedEntry);
                    }
                }
                $association->setEntry($entry);
                $entry->getAssociations()->add($association);
            }
        }
    }


    protected function parseAttribute($node)
    {
        $attribute = new Attribute();
        $attribute->setHandle((string) $node['handle']);
        $value = $this->attributeImporter->driver()->parse($node);
        $attribute->setAttributeValue($value);

        return $attribute;
    }

}