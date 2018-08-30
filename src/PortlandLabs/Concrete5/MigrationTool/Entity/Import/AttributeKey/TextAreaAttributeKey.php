<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\TextAreaFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\TextAreaPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportTextAreaAttributeKeys")
 */
class TextAreaAttributeKey extends AttributeKey
{
    /**
     * @ORM\Column(type="string")
     */
    protected $mode = '';

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function getType()
    {
        return 'textarea';
    }

    public function getFormatter()
    {
        return new TextAreaFormatter($this);
    }

    public function getTypePublisher()
    {
        return new TextAreaPublisher();
    }
}
