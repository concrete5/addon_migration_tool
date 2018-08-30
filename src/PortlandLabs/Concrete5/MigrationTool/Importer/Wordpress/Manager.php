<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Element\PageType;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{
    public function createPageDriver()
    {
        return new Page();
    }

    public function createPageTypeDriver()
    {
        return new PageType();
    }

    public function __construct()
    {
        $this->driver('page');
    }
}
