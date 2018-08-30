<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SelectFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeSelectValues")
 */
class SelectAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="json_array")
     */
    protected $select_value;

    public function getValue()
    {
        return $this->select_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($select_value)
    {
        $this->select_value = $select_value;
    }

    public function getFormatter()
    {
        return new SelectFormatter($this);
    }

    public function getPublisher()
    {
        return new StandardPublisher();
    }
}
