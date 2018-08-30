<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\ExpressEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ExpressEntity\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\TreeJsonFormatter;
/**
 * @ORM\Entity
 */
class EntityObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="Entity", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $entities;

    public function __construct()
    {
        $this->entities = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getEntities()
    {
        return $this->entities;
    }

    public function getFormatter()
    {
        return new ExpressEntityFormatter($this);
    }

    public function getType()
    {
        return 'express_entity';
    }

    public function hasRecords()
    {
        return count($this->getEntities());
    }

    public function getRecords()
    {
        return $this->getEntities();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new Validator($batch);
    }
}
