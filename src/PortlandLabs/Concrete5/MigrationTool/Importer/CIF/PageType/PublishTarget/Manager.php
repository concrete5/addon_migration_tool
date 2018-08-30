<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\PageType\PublishTarget;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{
    public function createParentPageDriver()
    {
        return new ParentPageImporter();
    }

    public function createPageTypeDriver()
    {
        return new PageTypeImporter();
    }

    public function createAllDriver()
    {
        return new AllPagesImporter();
    }
}
