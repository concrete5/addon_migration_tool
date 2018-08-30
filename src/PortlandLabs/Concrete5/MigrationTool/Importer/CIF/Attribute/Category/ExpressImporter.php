<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryInstance;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\ExpressAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class ExpressImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new ExpressAttributeKeyCategoryInstance();
    }

    public function loadFromXml(AttributeKeyCategoryInstance $category, \SimpleXMLElement $element)
    {
        return false;
    }
}
