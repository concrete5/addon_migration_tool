<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\Block;

use Concrete\Core\Support\Manager as CoreManager;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{
    public function driver($driver = null)
    {
        $method = 'create'.camelcase($driver).'Driver';
        // If a custom driver is not registered, we use unmapped
        if ($driver && !isset($this->customCreators[$driver]) && !method_exists($this, $method)) {
            return $this->createStandardDriver();
        }

        return parent::driver($driver);
    }

    public function getDefaultDriver()
    {
        return 'unmapped';
    }

    public function createStandardDriver()
    {
        return new StandardImporter();
    }
}
