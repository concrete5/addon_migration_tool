<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\DateTimeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\DateTimePublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportDateTimeAttributeKeys")
 */
class DateTimeAttributeKey extends AttributeKey
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
        return 'date_time';
    }

    public function getFormatter()
    {
        return new DateTimeFormatter($this);
    }

    public function getTypePublisher()
    {
        return new DateTimePublisher();
    }
}
