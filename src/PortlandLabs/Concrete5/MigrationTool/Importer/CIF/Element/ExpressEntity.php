<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\ExpressAttributeKeyCategoryInstance;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntityAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntityObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control\Manager;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntity implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new EntityObjectCollection();
        if ($element->expressentities->entity) {
            foreach ($element->expressentities->entity as $node) {
                $entity = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entity();
                $entity->setId((string) $node['id']);
                $entity->setHandle((string) $node['handle']);
                $entity->setPluralHandle((string) $node['plural_handle']);
                $entity->setDescription((string) $node['description']);
                $entity->setName((string) $node['name']);
                $entity->setResultsFolder((string) $node['results-folder']);
                $includeInPublicList = (string) $node['include_in_public_list'];
                if ($includeInPublicList === '1') {
                    $entity->setIncludeInPublicList(true);
                } else {
                    $entity->setIncludeInPublicList(false);
                }
                $entity->setDefaultEditFormId((string) $node['default_edit_form']);
                $entity->setDefaultViewFormId((string) $node['default_view_form']);

                if ($node->associations->association) {
                    foreach ($node->associations->association as $associationNode) {
                        $association = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Association();
                        $association->setID((string) $associationNode['id']);
                        $association->setType((string) $associationNode['type']);
                        $association->setTargetEntity((string) $associationNode['target-entity']);
                        $association->setSourceEntity((string) $associationNode['source-entity']);
                        $association->setTargetPropertyName((string) $associationNode['target-property-name']);
                        $association->setInversedByPropertyName((string) $associationNode['inversed-by-property-name']);
                        $entity->getAssociations()->add($association);
                        $association->setEntity($entity);
                    }
                }

                if ($node->attributekeys->attributekey) {
                    $attributeKeyParser = new AttributeKey('express');
                    $attributeKeyCollection = $attributeKeyParser->getObjectCollection($node, $batch);
                    foreach($attributeKeyCollection->getKeys() as $key) {
                        $key->getCategory()->setEntityHandle($entity->getHandle());
                    }
                    $entity->setAttributeKeys($attributeKeyCollection);
                }

                if ($node->forms->form) {
                    foreach ($node->forms->form as $formNode) {
                        $form = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Form();
                        $form->setName((string) $formNode['name']);
                        $form->setId((string) $formNode['id']);

                        if (isset($formNode->fieldsets)) {
                            foreach($formNode->fieldsets->fieldset as $setNode) {
                                $set = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\FieldSet();
                                $set->setTitle((string) $setNode['title']);
                                $set->setDescription((string) $setNode['description']);

                                if (isset($setNode->controls)) {
                                    $i = 0;
                                    $manager = \Core::make('migration/manager/import/express/control');
                                    foreach($setNode->controls->control as $controlNode) {
                                        $importer = $manager->driver((string) $controlNode['type']);
                                        $control = $importer->getEntity($controlNode);
                                        /**
                                         * @var $control Control
                                         */
                                        $required = (string) $controlNode['required'];
                                        if ($required === '1') {
                                            $control->setIsRequired(true);
                                        }
                                        $control->setCustomLabel((string) $controlNode['custom-label']);
                                        $control->setPosition($i);
                                        $importer->loadFromXml($control, $controlNode);

                                        $set->getControls()->add($control);
                                        $control->setFieldSet($set);
                                        $i++;
                                    }
                                }


                                $form->getFieldSets()->add($set);
                                $set->setForm($form);
                            }
                        }
                        $entity->getForms()->add($form);
                        $form->setEntity($entity);
                    }
                }

                $collection->getEntities()->add($entity);
                $entity->setCollection($collection);
            }
        }

        return $collection;
    }
}