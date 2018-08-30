<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

abstract class AbstractImporter implements BlockInterface
{
    protected $entityManager;

    public function __construct()
    {
        $manager = \Database::connection()->getEntityManager();
        $this->entityManager = $manager;
    }

    public function import(\SimpleXMLElement $node, $entity)
    {
        $block = $entity->getBlock();
        $block->setBlockValue($this->parse($node));

        $this->entityManager->persist($block);
        $this->entityManager->remove($entity);
    }
}
