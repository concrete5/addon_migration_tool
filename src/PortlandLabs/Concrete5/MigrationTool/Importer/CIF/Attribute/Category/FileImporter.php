<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryInstance;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\FileAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class FileImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new FileAttributeKeyCategoryInstance();
    }

    public function loadFromXml(AttributeKeyCategoryInstance $category, \SimpleXMLElement $element)
    {
        return false;
    }
}
