<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\StandardValidator;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Attribute\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\ImageFilePublisher;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\PagePublisher;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributePageValues")
 */
class PageAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="text")
     */
    protected $page_value;

    public function getValue()
    {
        return $this->page_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($page_value)
    {
        $this->page_value = $page_value;
    }

    public function getFormatter()
    {
        return new StandardFormatter($this);
    }

    public function getPublisher()
    {
        return new PagePublisher();
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
