<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    protected $object;

    /**
     * Returns the batch this object is in. I don't know why I didn't just
     * strongly tie these things together.
     */
    protected function getBatch(PublishableInterface $object)
    {
        $em = \Database::connection()->getEntityManager();
        $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $collection = $object->getCollection();
        $batch = $r->findFromCollection($collection);
        return $batch;
    }

    public function __construct(PublishableInterface $object)
    {
        $this->object = $object;
    }
}
