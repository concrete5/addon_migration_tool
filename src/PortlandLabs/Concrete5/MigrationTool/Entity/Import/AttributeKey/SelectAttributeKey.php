<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\SelectFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey\SelectPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportSelectAttributeKeys")
 */
class SelectAttributeKey extends AttributeKey
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $allow_multiple_values = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $allow_other_values = false;

    /**
     * @ORM\Column(type="string")
     */
    protected $display_order = 'display_asc';

    /**
     * @ORM\Column(type="json_array")
     */
    protected $options = array();

    /**
     * @return mixed
     */
    public function getAllowMultipleValues()
    {
        return $this->allow_multiple_values;
    }

    /**
     * @param mixed $allow_multiple_values
     */
    public function setAllowMultipleValues($allow_multiple_values)
    {
        $this->allow_multiple_values = $allow_multiple_values;
    }

    /**
     * @return mixed
     */
    public function getAllowOtherValues()
    {
        return $this->allow_other_values;
    }

    /**
     * @param mixed $allow_other_values
     */
    public function setAllowOtherValues($allow_other_values)
    {
        $this->allow_other_values = $allow_other_values;
    }

    /**
     * @return mixed
     */
    public function getDisplayOrder()
    {
        return $this->display_order;
    }

    /**
     * @param mixed $display_order
     */
    public function setDisplayOrder($display_order)
    {
        $this->display_order = $display_order;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getType()
    {
        return 'select';
    }

    public function getFormatter()
    {
        return new SelectFormatter($this);
    }

    public function getTypePublisher()
    {
        return new SelectPublisher();
    }
}
