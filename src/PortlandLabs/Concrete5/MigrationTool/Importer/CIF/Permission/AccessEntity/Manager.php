<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Permission\AccessEntity;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{
    public function driver($driver = null)
    {
        // If a custom driver is not registered, we use unmapped
        if (!isset($this->customCreators[$driver])) {
            return new BasicImporter();
        }

        return parent::driver($driver);
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->extend('user', function () {
            return new UserImporter();
        });
        $this->extend('group', function () {
            return new GroupImporter();
        });
    }
}
