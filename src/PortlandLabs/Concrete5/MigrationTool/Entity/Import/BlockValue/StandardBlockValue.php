<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\Manager;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Table(name="MigrationImportStandardBlockValues")
 * @ORM\Entity
 */
class StandardBlockValue extends BlockValue
{
    /**
     * @ORM\OneToMany(targetEntity="StandardBlockDataRecord", mappedBy="value", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     **/
    public $records;

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        $manager = \Core::make('migration/manager/publisher/block');
        $type = $this->getBlock()->getType();
        return $manager->driver($type);
    }

    /**
     * @return mixed
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param mixed $records
     */
    public function setRecords($records)
    {
        $this->records = $records;
    }

    public function getInspector()
    {
        return new StandardInspector($this);
    }

    public function __construct()
    {
        $this->records = new ArrayCollection();
    }
}
