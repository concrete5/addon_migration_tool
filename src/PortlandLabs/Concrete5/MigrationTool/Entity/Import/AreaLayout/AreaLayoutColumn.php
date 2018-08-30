<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAreaLayoutColumns")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
abstract class AreaLayoutColumn
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AreaLayoutColumnBlock", cascade={"persist", "remove"}, mappedBy="column")
     */
    protected $blocks;

    /**
     * @ORM\ManyToOne(targetEntity="AreaLayout")
     **/
    protected $area_layout;

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
    public function getAreaLayout()
    {
        return $this->area_layout;
    }

    /**
     * @param mixed $area_layout
     */
    public function setAreaLayout($area_layout)
    {
        $this->area_layout = $area_layout;
    }

    /**
     * @return mixed
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param mixed $blocks
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;
    }

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }
}
