<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTypeItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageTypeItemValidator;

defined('C5_EXECUTE') or die("Access Denied.");

class PageTypePublishTargetValidator extends AbstractValidator
{
    public function validate($entity)
    {
        $messages = new MessageCollection();
        $validator = new PageTypeItemValidator();
        $item = new PageTypeItem($entity->getPageType());
        if (!$validator->itemExists($item, $this->getBatch())) {
            $validator->addMissingItemMessage($item, $messages);
        }

        return $messages;
    }
}
