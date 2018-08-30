<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class CollectionValidatorTarget extends ValidatorTarget
{
    protected $blocks;

    public function __construct(Batch $batch, $blocks)
    {
        parent::__construct($batch);
        $this->blocks = $blocks;
    }

    public function getItems()
    {
        return array($this->blocks);
    }

}
