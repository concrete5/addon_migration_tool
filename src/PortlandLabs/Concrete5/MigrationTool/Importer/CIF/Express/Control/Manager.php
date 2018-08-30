<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Express\Control;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{
    public function createEntityPropertyDriver()
    {
        return new EntityPropertyImporter();
    }

    public function createAttributeKeyDriver()
    {
        return new AttributeKeyImporter();
    }

    public function createAssociationDriver()
    {
        return new AssociationImporter();
    }


}
