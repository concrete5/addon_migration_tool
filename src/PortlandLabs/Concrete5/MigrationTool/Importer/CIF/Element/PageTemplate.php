<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplate as CorePageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageTemplateObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTemplate implements ElementParserInterface
{
    protected $simplexml;

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $collection = new PageTemplateObjectCollection();
        if ($this->simplexml->pagetemplates->pagetemplate) {
            foreach ($this->simplexml->pagetemplates->pagetemplate as $node) {
                $template = new CorePageTemplate();
                $template->setHandle((string) $node['handle']);
                $template->setIcon((string) $node['icon']);
                $template->setName((string) $node['name']);
                $template->setPackage((string) $node['package']);
                $collection->getTemplates()->add($template);
                $template->setCollection($collection);
            }
        }

        return $collection;
    }
}
