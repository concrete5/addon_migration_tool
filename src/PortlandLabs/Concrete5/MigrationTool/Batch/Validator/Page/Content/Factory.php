<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageFeedItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTypeItem;

defined('C5_EXECUTE') or die("Access Denied.");

class Factory
{
    protected $validator;

    public function __construct(ItemInterface $item)
    {
        if ($item instanceof PageItem) {
            $this->validator = new PageItemValidator();
        }

        if ($item instanceof PageFeedItem) {
            $this->validator = new PageFeedItemValidator();
        }

        if ($item instanceof PageTypeItem) {
            $this->validator = new PageTypeItemValidator();
        }

        if ($item instanceof FileItem) {
            $this->validator = new FileItemValidator();
        }

        if (!$this->validator) {
            $this->validator = new StandardItemValidator();
        }
    }

    public function getValidator()
    {
        return $this->validator;
    }
}
