<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class PagePublisher implements PublisherInterface
{
    public function publish(Batch $batch, $ak, $subject, AttributeValue $value)
    {
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($value->getValue());
        $items = $result->getMatchedItems();

        if (isset($items[0]) && $items[0] instanceof PageItem) {
            $page = $items[0]->getContentObject();
            if ($page) {
                $subject->setAttribute($ak->getAttributeKeyHandle(), $page);
            }
        }
    }
}
