<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey\AccessEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey\AccessEntityValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Permission\AccessEntityPublisher;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="MigrationImportPermissionAccessEntities")
 */
class AccessEntity
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Key")
     **/
    protected $key;

    /**
     * @ORM\Column(type="string")
     */
    protected $entity_type;

    /**
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entity_type;
    }

    /**
     * @param mixed $entity_type
     */
    public function setEntityType($entity_type)
    {
        $this->entity_type = $entity_type;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFormatter()
    {
        return new AccessEntityFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new AccessEntityValidator($batch);
    }

    public function getPublisher()
    {
        return new AccessEntityPublisher();
    }
}
