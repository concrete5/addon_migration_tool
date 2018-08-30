<?php
namespace Concrete\Package\MigrationTool\Controller\Element\Dashboard\Batches\Settings;

use Concrete\Core\Controller\ElementController;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class Header extends ElementController
{

    protected $batch;

    public function getElement()
    {
        return 'dashboard/batches/settings/header';
    }

    public function getPackageHandle()
    {
        return 'migration_tool';
    }

    public function __construct(Batch $type)
    {
        $this->batch = $type;
        parent::__construct();
    }

    public function view()
    {
        $this->set('batch', $this->batch);
    }

}
