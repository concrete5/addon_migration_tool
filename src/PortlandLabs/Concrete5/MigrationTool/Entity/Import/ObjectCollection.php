<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Concrete\Core\Application\Application;
use Concrete\Core\Support\Facade\Facade;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\StandardItemLogger;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\StandardLogger;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportObjectCollections")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class ObjectCollection
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    abstract public function hasRecords();

    abstract public function getFormatter();

    abstract public function getTreeFormatter();

    abstract public function getType();

    abstract public function getRecords();

    public function getRecordByID($id)
    {
        foreach($this->getRecords() as $record) {
            if ($record->getID() == $id) {
                return $record;
            }
        }
    }

    abstract public function getRecordValidator(ValidatorInterface $batch);

}
