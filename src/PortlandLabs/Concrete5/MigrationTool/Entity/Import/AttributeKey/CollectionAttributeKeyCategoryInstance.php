<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\CollectionPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CollectionAttributeKeyCategoryInstance extends AttributeKeyCategoryInstance
{
    public function getHandle()
    {
        return 'collection';
    }

    public function getFormatter()
    {
        return false;
    }

    public function getPublisher()
    {
        return new CollectionPublisher();
    }
}
