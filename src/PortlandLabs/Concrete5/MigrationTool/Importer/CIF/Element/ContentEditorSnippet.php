<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ContentEditorSnippetObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class ContentEditorSnippet implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new ContentEditorSnippetObjectCollection();
        if ($element->systemcontenteditorsnippets->snippet) {
            foreach ($element->systemcontenteditorsnippets->snippet as $node) {
                $snippet = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\ContentEditorSnippet();
                $snippet->setHandle((string) $node['handle']);
                $snippet->setName((string) $node['name']);
                $snippet->setPackage((string) $node['package']);
                $snippet->setIsActivated((string) $node['activated']);
                $collection->getSnippets()->add($snippet);
                $snippet->setCollection($collection);
            }
        }

        return $collection;
    }
}
