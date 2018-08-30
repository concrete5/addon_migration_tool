<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ExpressEntry;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Site;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressEntryValidatorTarget extends ValidatorTarget
{
    protected $entry;

    public function __construct(Batch $batch, Entry $entry)
    {
        parent::__construct($batch);
        $this->entry = $entry;
    }

    public function getItems()
    {
        return array($this->entry);
    }

}
