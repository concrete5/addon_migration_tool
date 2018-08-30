<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\ImageFileAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\PageAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class PageImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new PageAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        return false;
    }
}
