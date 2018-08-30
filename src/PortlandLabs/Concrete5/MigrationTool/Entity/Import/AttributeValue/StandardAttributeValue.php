<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\StandardValidator;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Attribute\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeStandardValues")
 */
class StandardAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="text")
     */
    protected $standard_value;

    public function getValue()
    {
        return $this->standard_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($standard_value)
    {
        $this->standard_value = $standard_value;
    }

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        return new StandardPublisher();
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new StandardValidator($batch);
    }

    public function getInspector()
    {
        return new StandardInspector($this);
    }

}
