<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Permission;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey\Validator as PermissionKeyValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PermissionKey\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\PermissionKeyFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 */
class KeyObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="Key", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $keys;

    public function __construct()
    {
        $this->keys = new ArrayCollection();
    }

    public function getFormatter()
    {
        return new PermissionKeyFormatter($this);
    }

    /**
     * @return mixed
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @param mixed $keys
     */
    public function setKeys($keys)
    {
        $this->keys = $keys;
    }

    public function getType()
    {
        return 'permission_key';
    }

    public function hasRecords()
    {
        return count($this->getKeys());
    }

    public function getRecords()
    {
        return $this->getKeys();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new PermissionKeyValidator($batch);
    }
}
