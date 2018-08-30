<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\ConfigValueFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ConfigValueObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="ConfigValue", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }

    public function getFormatter()
    {
        return new ConfigValueFormatter($this);
    }

    public function getType()
    {
        return 'config_value';
    }

    public function hasRecords()
    {
        return count($this->getValues());
    }

    public function getRecords()
    {
        return $this->getValues();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return false;
    }
}
