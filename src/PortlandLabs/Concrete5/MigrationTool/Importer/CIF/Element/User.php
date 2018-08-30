<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Area;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserAttribute;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserGroup;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\UserObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;
use PortlandLabs\Concrete5\MigrationTool\Importer\Sanitizer\PagePathSanitizer;

class User implements ElementParserInterface
{
    protected $attributeImporter;
    protected $simplexml;

    public function __construct()
    {
        $this->attributeImporter = \Core::make('migration/manager/import/attribute/value');
    }

    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $this->simplexml = $element;
        $i = 0;
        $collection = new UserObjectCollection();
        if ($element->users->user) {
            foreach ($element->users->user as $node) {
                $user = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\User();
                $user->setName((string) $node['username']);
                $user->setEmail((string) $node['email']);

                if ((string) $node['inactive']) {
                    $user->setIsActive(false);
                }

                if ((string) $node['unvalidated']) {
                    $user->setIsValidated(false);
                }

                $user->setTimezone((string) $node['timezone']);
                $user->setLanguage((string) $node['language']);

                // Parse attributes
                if ($node->attributes->attributekey) {
                    foreach ($node->attributes->attributekey as $keyNode) {
                        $attribute = $this->parseAttribute($keyNode);
                        $userAttribute = new UserAttribute();
                        $userAttribute->setAttribute($attribute);
                        $userAttribute->setUser($user);
                        $user->getAttributes()->add($userAttribute);
                    }
                }

                // Groups
                if ($node->groups->group) {
                    foreach ($node->groups->group as $groupNode) {
                        $userGroup = new UserGroup();
                        $userGroup->setName((string) $groupNode['name']);
                        $userGroup->setPath((string) $groupNode['path']);
                        $userGroup->setUser($user);
                        $user->getGroups()->add($userGroup);
                    }
                }

                $collection->getUsers()->add($user);
                $user->setCollection($collection);
            }
        }

        return $collection;
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
