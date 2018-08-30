<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\User;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Site;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\User;

defined('C5_EXECUTE') or die("Access Denied.");

class UserValidatorTarget extends ValidatorTarget
{
    protected $user;

    public function __construct(Batch $batch, User $user)
    {
        parent::__construct($batch);
        $this->user = $user;
    }

    public function getItems()
    {
        return array($this->user);
    }

}
