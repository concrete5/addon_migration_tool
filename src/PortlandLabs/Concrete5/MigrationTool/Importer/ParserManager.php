<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\CIFParser;
use PortlandLabs\Concrete5\MigrationTool\Importer\Wordpress\WordpressParser;

defined('C5_EXECUTE') or die("Access Denied.");

class ParserManager extends CoreManager
{
    public function createConcrete5Driver()
    {
        return new CIFParser();
    }

    public function createWordpressDriver()
    {
        return new WordpressParser();
    }

    public function __construct()
    {
        $this->driver('concrete5');
        $this->driver('wordpress');
    }
}
