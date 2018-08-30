<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\ImportedFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\CIFPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeImportedValues")
 */
class ImportedAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="text")
     */
    protected $imported_value;

    public function getValue()
    {
        return $this->imported_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($imported_value)
    {
        $this->imported_value = $imported_value;
    }

    public function getFormatter()
    {
        return new ImportedFormatter($this);
    }

    public function getPublisher()
    {
        return new CIFPublisher();
    }
}
