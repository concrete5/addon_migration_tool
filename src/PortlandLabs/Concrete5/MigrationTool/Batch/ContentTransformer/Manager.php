<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\UserAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\ExpressAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\SiteAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentTransformer\Type\BlockType;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager
{
    protected function createPageAttributeDriver()
    {
        return new PageAttribute();
    }

    protected function createSiteAttributeDriver()
    {
        return new SiteAttribute();
    }

    protected function createUserAttributeDriver()
    {
        return new UserAttribute();
    }

    protected function createExpressAttributeDriver()
    {
        return new ExpressAttribute();
    }

    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->driver('user_attribute');
        $this->driver('page_attribute');
        $this->driver('site_attribute');
        $this->driver('express_attribute');
        $this->driver('block_type');
    }
}
