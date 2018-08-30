<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportBlockValueDataRecords")
 */
class StandardBlockDataRecord
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $data;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $record_table;

    /**
     * @ORM\ManyToOne(targetEntity="StandardBlockValue")
     **/
    protected $value;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->record_table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($record_table)
    {
        $this->record_table = $record_table;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
