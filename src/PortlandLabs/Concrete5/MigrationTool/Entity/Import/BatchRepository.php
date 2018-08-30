<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\ORM\EntityRepository;

class BatchRepository extends EntityRepository
{
    public function findFromCollection(ObjectCollection $collection)
    {
        $query = $this->getEntityManager()->createQuery('select b from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch b inner join b.collections c where c.id = :id');
        $query->setParameter('id', $collection->getID());
        // I don't know why this is returning multiple results. Something off about the join.
        $r = $query->getOneOrNullResult();

        return $r;
    }
}
