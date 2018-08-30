<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractFormatter implements FormatterInterface
{
    protected $collection;

    public function __construct(ObjectCollection $collection)
    {
        $this->collection = $collection;
    }

    public function getElement()
    {
        return $this->collection->getType();
    }

    protected function getPackageHandle()
    {
        return 'migration_tool';
    }

    public function displayObjectCollection()
    {
        $em = \Package::getByHandle('migration_tool')->getEntityManager();
        $identifier = \Core::make('helper/validation/identifier');
        $r = $em->getRepository("\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch");
        $batch = $r->findFromCollection($this->collection);
        echo \View::element('batch_content_types/'
            . $this->getElement(), array(
            'batch' => $batch,
            'type' => $this->collection->getType(),
            'collection' => $this->collection,
            'identifier' => $identifier->getString(32)
        ), $this->getPackageHandle());
    }
}
