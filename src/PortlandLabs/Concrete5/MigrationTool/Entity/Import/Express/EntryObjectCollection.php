<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\ExpressEntityFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\ExpressEntryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ExpressEntry\Validator;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntry\TreeJsonFormatter;
/**
 * @ORM\Entity
 */
class EntryObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    public function getFormatter()
    {
        return new ExpressEntryFormatter($this);
    }

    public function getType()
    {
        return 'express_entry';
    }

    public function hasRecords()
    {
        return count($this->getEntries());
    }

    public function getRecords()
    {
        return $this->getEntries();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return \Core::make('migration/batch/express/entry/validator', array($batch));
    }
}
