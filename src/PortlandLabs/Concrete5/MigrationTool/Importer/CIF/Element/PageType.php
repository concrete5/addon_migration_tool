<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\BlockComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CollectionAttributeComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\ComposerFormLayoutSet;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\CorePagePropertyComposerFormLayoutSetControl;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageTypeObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class PageType implements ElementParserInterface
{
    protected function getComposerControlEntityObject($type)
    {
        switch ($type) {
            case 'core_page_property':
                return new CorePagePropertyComposerFormLayoutSetControl();
            case 'collection_attribute':
                return new CollectionAttributeComposerFormLayoutSetControl();
            case 'block':
                return new BlockComposerFormLayoutSetControl();
        }
    }

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new PageTypeObjectCollection();
        $targets = \Core::make('migration/manager/import/page_type/publish_target');
        if ($element->pagetypes->pagetype) {
            foreach ($element->pagetypes->pagetype as $node) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType();
                $type->setHandle((string) $node['handle']);
                $type->setName((string) $node['name']);
                $type->setPackage((string) $node['package']);

                if ((string) $node->pagetemplates['type'] == 'custom' || (string) $node->pagetemplates['type'] == 'except') {
                    if ((string) $node->pagetemplates['type'] == 'custom') {
                        $allowed = 'C';
                    } else {
                        $allowed = 'X';
                    }
                } else {
                    $allowed = 'A';
                }

                $type->setAllowedTemplates($allowed);
                $templates = array();
                foreach ($node->pagetemplates->pagetemplate as $template) {
                    $templates[] = (string) $template['handle'];
                }
                $type->setDefaultTemplate((string) $node->pagetemplates['default']);
                $type->setTemplates($templates);
                $type->setIsInternal((bool) $node['internal']);
                $type->setLaunchInComposer((bool) $node['launch-in-composer']);
                $type->setIsFrequentlyAdded((bool) $node['is-frequently-added']);
                $target = $targets->driver((string) $node->target['handle']);
                $targetEntity = $target->getEntity();
                $target->loadFromXml($targetEntity, $node->target);
                $type->setPublishTarget($targetEntity);

                if (isset($node->composer->formlayout->set)) {
                    $i = 0;
                    foreach ($node->composer->formlayout->set as $setNode) {
                        $layoutSet = new ComposerFormLayoutSet();
                        $layoutSet->setName((string) $setNode['name']);
                        $layoutSet->setDescription((string) $setNode['description']);
                        $layoutSet->setPosition($i);

                        if (isset($setNode->control)) {
                            $j = 0;
                            foreach ($setNode->control as $controlNode) {
                                $control = $this->getComposerControlEntityObject((string) $controlNode['type']);
                                $control->setIsRequired((bool) $controlNode['required']);
                                $control->setItemIdentifier((string) $controlNode['handle']);
                                $control->setCustomLabel($controlNode['custom-label']);
                                $control->setCustomTemplate($controlNode['custom-template']);
                                $control->setDescription($controlNode['description']);
                                $control->setOutputControlId($controlNode['output-control-id']);
                                $control->setPosition($j);
                                $layoutSet->getControls()->add($control);
                                $control->setComposerFormLayoutSet($layoutSet);
                                ++$j;
                            }
                        }
                        $type->getLayoutSets()->add($layoutSet);
                        $layoutSet->setType($type);
                        ++$i;
                    }
                }

                if (isset($node->composer->output->pagetemplate)) {
                    $pi = new PageTypeDefaultPage($type);
                    foreach ($node->composer->output->pagetemplate as $pagetemplate) {
                        $pageCollection = $pi->getObjectCollection($pagetemplate, $batch);
                        $type->setDefaultPageCollection($pageCollection);
                    }
                }

                $collection->getTypes()->add($type);
                $type->setCollection($collection);
            }
        }

        return $collection;
    }
}
