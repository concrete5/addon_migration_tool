<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Type\Attribute;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{
    public function createFileDriver()
    {
        return new FileImporter();
    }

    public function createExpressDriver()
    {
        return new ExpressImporter();
    }

    public function createCollectionDriver() /* page */
    {
        return new CollectionImporter();
    }

    public function createUserDriver()
    {
        return new UserImporter();
    }

    public function getAttributeCategoryMapper($category)
    {
        $mappers = $this->app->make('migration/manager/mapping')->getDrivers();
        foreach($mappers as $mapper) {
            if ($mapper instanceof Attribute) {
                if ($mapper->getAttributeKeyCategoryHandle() == $category) {
                    return $mapper;
                }
            }
        }
    }
}
