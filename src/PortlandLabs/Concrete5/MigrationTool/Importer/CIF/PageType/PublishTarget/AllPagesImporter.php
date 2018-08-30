<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\PageType\PublishTarget;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\AllPagesPublishTarget;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PublishTarget;

defined('C5_EXECUTE') or die("Access Denied.");

class AllPagesImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new AllPagesPublishTarget();
    }

    /**
     * @param AllPagesPublishTarget $target
     * @param \SimpleXMLElement $element
     */
    public function loadFromXml(PublishTarget $target, \SimpleXMLElement $element)
    {
        $target->setFormFactor((string) $element['form-factor']);
    }
}
