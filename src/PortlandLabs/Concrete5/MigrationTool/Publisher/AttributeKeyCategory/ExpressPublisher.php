<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Attribute\Key\FileKey;
use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Entity\Express\Entity;
use Concrete\Core\Express\ObjectManager;
use Concrete\Core\Package\Package;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressPublisher implements PublisherInterface
{

    protected $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    public function publish(AttributeKey $ak, Package $pkg = null)
    {
        $key = new \Concrete\Core\Entity\Attribute\Key\ExpressKey();
        $key->setEntity($this->entity);
        $key->setAttributeKeyHandle($ak->getHandle());
        $key->setAttributeKeyName($ak->getName());
        $key->setIsAttributeKeyInternal($ak->getIsInternal());
        $key->setIsAttributeKeyContentIndexed($ak->getIsIndexed());
        $key->setIsAttributeKeySearchable($ak->getIsSearchable());
        return $key;
    }
}
