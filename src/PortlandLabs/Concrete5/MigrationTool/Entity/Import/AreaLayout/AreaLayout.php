<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAreaLayouts")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class AreaLayout
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\BLockValue\AreaLayoutBlockValue", mappedBy="area_layout")
     **/
    protected $block_value;

    /**
     * @ORM\OneToMany(targetEntity="AreaLayoutColumn", mappedBy="area_layout", cascade={"persist", "remove"})
     **/
    protected $columns;

    /**
     * @return mixed
     */
    public function getBlockValue()
    {
        return $this->block_value;
    }

    /**
     * @param mixed $block_value
     */
    public function setBlockValue($block_value)
    {
        $this->block_value = $block_value;
    }

    /**
     * @return AreaLayoutColumn[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function __construct()
    {
        $this->columns = new ArrayCollection();
    }

    /**
     * @return \PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout\PublisherInterface
     */
    abstract public function getPublisher();
}
