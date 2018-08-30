<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\PageType\PublishTarget;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PublishTarget;

defined('C5_EXECUTE') or die("Access Denied.");

interface ImporterInterface
{
    public function getEntity();
    public function loadFromXml(PublishTarget $entity, \SimpleXMLElement $element);
}
