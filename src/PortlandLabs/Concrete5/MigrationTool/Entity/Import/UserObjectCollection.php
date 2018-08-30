<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\JobFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\UserFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\User\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\User", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getFormatter()
    {
        return new UserFormatter($this);
    }

    public function getType()
    {
        return 'user';
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }


    public function hasRecords()
    {
        return count($this->getUsers());
    }

    public function getRecords()
    {
        return $this->getUsers();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return \Core::make('migration/batch/user/validator', array($batch));
    }
}
