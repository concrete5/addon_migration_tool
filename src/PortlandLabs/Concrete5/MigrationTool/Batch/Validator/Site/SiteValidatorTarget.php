<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Site;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorTargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Site;

defined('C5_EXECUTE') or die("Access Denied.");

class SiteValidatorTarget extends ValidatorTarget
{
    protected $site;

    public function __construct(Batch $batch, Site $site)
    {
        parent::__construct($batch);
        $this->site = $site;
    }

    public function getItems()
    {
        return array($this->site);
    }

}
