<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SelectFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\StandardPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeTopicsValues")
 */
class TopicsAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="json_array")
     */
    protected $topics_value;

    public function getValue()
    {
        return $this->topics_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($topics_value)
    {
        $this->topics_value = $topics_value;
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
