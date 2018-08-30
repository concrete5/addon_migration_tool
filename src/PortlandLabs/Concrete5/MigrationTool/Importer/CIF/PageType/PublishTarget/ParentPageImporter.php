<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\PageType\PublishTarget;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\ParentPagePublishTarget;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PublishTarget;

defined('C5_EXECUTE') or die("Access Denied.");

class ParentPageImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new ParentPagePublishTarget();
    }

    /**
     * @param ParentPagePublishTarget $entity
     * @param \SimpleXMLElement $element
     */
    public function loadFromXml(PublishTarget $entity, \SimpleXMLElement $element)
    {
        $entity->setPath((string) $element['path']);
    }
}
