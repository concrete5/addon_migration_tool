<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;

use Doctrine\ORM\EntityRepository;

class BatchRepository extends EntityRepository
{
    public function findFromCollection(ObjectCollection $collection)
    {
        $query = $this->getEntityManager()->createQuery('select b from \PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch b inner join PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection o where o.id = :id');
        $query->setParameter('id', $collection->getID());
        // I don't know why this is returning multiple results. Something off about the join.
        $r = $query->getResult();

        return $r[0];
    }
}
