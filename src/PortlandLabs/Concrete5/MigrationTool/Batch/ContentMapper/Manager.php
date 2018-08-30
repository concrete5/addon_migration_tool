<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use Concrete\Core\Support\Manager as CoreManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Area;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\UserAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ExpressAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\SiteAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageAttribute;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\ComposerOutputContent;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\PageType;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\User;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\UserGroup;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchTargetItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends CoreManager implements MapperManagerInterface
{
    public function createTargetItemList(BatchInterface $batch, MapperInterface $mapper)
    {
        return new TargetItemList($batch, $mapper);
    }

    public function createBatchTargetItem()
    {
        return new BatchTargetItem();
    }

    protected function createPageAttributeDriver()
    {
        return new PageAttribute();
    }

    protected function createUserGroupDriver()
    {
        return new UserGroup();
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

    protected function createPageTemplateDriver()
    {
        return new PageTemplate();
    }

    protected function createPageTypeDriver()
    {
        return new PageType();
    }

    protected function createUserDriver()
    {
        return new User();
    }

    protected function createBlockTypeDriver()
    {
        return new BlockType();
    }

    protected function createComposerOutputContentDriver()
    {
        return new ComposerOutputContent();
    }

    protected function createAreaDriver()
    {
        return new Area();
    }

    public function __construct()
    {
        $this->driver('area');
        $this->driver('page_attribute');
        $this->driver('site_attribute');
        $this->driver('user_attribute');
        $this->driver('express_attribute');
        $this->driver('block_type');
        $this->driver('composer_output_content');
        $this->driver('page_template');
        $this->driver('page_type');
        $this->driver('user');
        $this->driver('user_group');
    }
}
