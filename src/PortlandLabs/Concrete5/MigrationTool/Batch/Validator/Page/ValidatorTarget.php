<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatorTarget extends \PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTarget
{
    protected $page;

    public function __construct(Batch $batch, Page $page)
    {
        parent::__construct($batch);
        $this->page = $page;
    }

    public function getItems()
    {
        return array($this->page);
    }

}
