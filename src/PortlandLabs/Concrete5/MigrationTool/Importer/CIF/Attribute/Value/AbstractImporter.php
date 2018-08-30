<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractImporter implements ValueInterface
{
    protected $entityManager;

    public function __construct()
    {
        $manager = \Database::connection()->getEntityManager();
        $this->entityManager = $manager;
    }

    public function import(\SimpleXMLElement $node, $entity)
    {
        $attribute = $entity->getAttribute();
        $value = $this->parse($node);
        $attribute->setAttributeValue($value);

        $this->entityManager->persist($attribute);
        $this->entityManager->remove($entity);
    }
}
