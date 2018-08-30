<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\ExpressEntity\Control;

use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use Concrete\Core\Entity\Express\Association;

defined('C5_EXECUTE') or die("Access Denied.");

class AssociationControl implements PublisherInterface
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\AssociationControl $source
     * @param $destination
     *
     * @return mixed
     */
    public function getControl(Control $source)
    {
        $r = $this->entityManager->getRepository(Association::class);
        $association = $r->findOneById($source->getAssociation());
        $control = new \Concrete\Core\Entity\Express\Control\AssociationControl();
        $control->setAssociation($association);
        return $control;
    }
}
