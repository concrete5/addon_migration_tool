<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use Concrete\Core\Attribute\Category\ExpressCategory;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\ExpressPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ExpressAttributeKeyCategoryInstance extends AttributeKeyCategoryInstance
{
    /**
     * @ORM\Column(type="string")
     */
    protected $entity_handle = '';

    public function getHandle()
    {
        return 'express';
    }

    public function getFormatter()
    {
        return false;
    }

    public function getPublisher()
    {
        $entity = \Express::getObjectByHandle($this->entity_handle);
        return new ExpressPublisher($entity);
    }

    /**
     * @return mixed
     */
    public function getEntityHandle()
    {
        return $this->entity_handle;
    }

    /**
     * @param mixed $entity_handle
     */
    public function setEntityHandle($entity_handle)
    {
        $this->entity_handle = $entity_handle;
    }

    public function getAttributeController()
    {
        $entity = \Express::getObjectByHandle($this->getEntityHandle());
        return new ExpressCategory($entity, \Core::make('app'), \Core::make(EntityManager::class));
    }



}
