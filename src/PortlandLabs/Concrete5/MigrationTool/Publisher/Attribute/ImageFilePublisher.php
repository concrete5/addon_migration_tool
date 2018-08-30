<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\FileItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageFilePublisher implements PublisherInterface
{
    public function publish(Batch $batch, $ak, $subject, AttributeValue $value)
    {
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($value->getValue());
        $items = $result->getMatchedItems();

        if (isset($items[0]) && $items[0] instanceof FileItem) {
            $file = $items[0]->getContentObject();
            if ($file) {
                $subject->setAttribute($ak->getAttributeKeyHandle(), $file);
            }
        }
    }
}
