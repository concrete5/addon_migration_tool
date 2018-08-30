<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Processor;

use Concrete\Core\Foundation\Processor\TargetInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\EmptyMapper;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Target implements TargetInterface
{
    protected $batch;
    protected $itemsToReturn;

    const RETURN_PAGES = 1;
    const RETURN_MAPPED_ITEMS = 2;
    const RETURN_UNTRANSFORMED_ITEMS = 3;

    public function __construct(Batch $batch, $itemsToReturn = self::RETURN_PAGES)
    {
        $this->batch = $batch;
        $this->itemsToReturn = $itemsToReturn;
    }

    public function returnMappedItems()
    {
        $this->itemsToReturn = self::RETURN_MAPPED_ITEMS;
    }

    public function returnUntransformedItems()
    {
        $this->itemsToReturn = self::RETURN_UNTRANSFORMED_ITEMS;
    }

    /**
     * @return Section
     */
    public function getBatch()
    {
        return $this->batch;
    }

    public function __sleep()
    {
        return array('batch');
    }

    public function getItems()
    {
        $mappers = \Core::make('migration/manager/mapping');
        switch ($this->itemsToReturn) {
            case self::RETURN_PAGES:
                return $this->batch->getPages();
            case self::RETURN_MAPPED_ITEMS:
                $items = array();
                foreach ($mappers->getDrivers() as $mapper) {
                    foreach ($mapper->getItems($this->batch) as $item) {
                        $r = array();
                        $r['mapper'] = $mapper->getHandle();
                        $r['item'] = $item->getIdentifier();
                        $items[] = $r;
                    }
                }

                return $items;
            case self::RETURN_UNTRANSFORMED_ITEMS:
                $items = array();
                $transformers = \Core::make('migration/manager/transforms');
                foreach ($transformers->getDrivers() as $transformer) {
                    try {
                        $mapper = $mappers->driver($transformer->getDriver());
                    } catch (\Exception $e) {
                        // No mapper for this type.}
                        $mapper = new EmptyMapper();
                    }

                    $untransformed = $transformer->getUntransformedEntityObjects($mapper, $this->batch);
                    foreach ($untransformed as $entity) {
                        $items[] = array(
                            'entity' => $entity->getID(),
                            'mapper' => $mapper->getHandle(),
                            'transformer' => $transformer->getDriver(),
                        );
                    }
                }

                return $items;
        }
    }
}
