<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\StandardValidator;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Attribute\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\ImageFilePublisher;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeImageFileValues")
 */
class ImageFileAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="text")
     */
    protected $image_file_value;

    public function getValue()
    {
        return $this->image_file_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($image_file_value)
    {
        $this->image_file_value = $image_file_value;
    }

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        return new ImageFilePublisher();
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
