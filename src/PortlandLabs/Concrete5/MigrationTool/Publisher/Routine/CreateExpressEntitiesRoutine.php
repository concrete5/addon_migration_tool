<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Entity\Express\Entity;
use Concrete\Core\Entity\Express\OneToOneAssociation;
use Concrete\Core\Entity\Sharing\SocialNetwork\Link;
use Concrete\Core\Express\ObjectAssociationBuilder;
use Doctrine\ORM\Id\UuidGenerator;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Association;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateExpressEntitiesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $entities = $batch->getObjectCollection('express_entity');


        if (!$entities) {
            return;
        }

        $em = \Database::connection()->getEntityManager();
        $em->getClassMetadata('Concrete\Core\Entity\Express\Entity')->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

        foreach ($entities->getEntities() as $entity) {
            if (!$entity->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($entity);

                $publishedEntity = new Entity();
                $publishedEntity->setId($entity->getId());
                $publishedEntity->setHandle($entity->getHandle());
                $publishedEntity->setName($entity->getName());
                $publishedEntity->setDescription($entity->getDescription());
                $publishedEntity->setPluralHandle($entity->getPluralHandle());
                $publishedEntity->setLabelMask($entity->getLabelMask());

                $em->persist($publishedEntity);
                $em->flush();

                $logger->logPublishComplete($entity, $publishedEntity);
            } else {
                $logger->logSkipped($entity);
            }
        }

        $em->getClassMetadata('Concrete\Core\Entity\Express\Entity')->setIdGenerator(new UuidGenerator());

    }
}
