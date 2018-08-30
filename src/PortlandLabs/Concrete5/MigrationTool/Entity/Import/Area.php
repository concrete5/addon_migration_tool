<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAreas")
 */
class Area
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block", mappedBy="area", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     **/
    public $blocks;

    /**
     * @ORM\ManyToOne(targetEntity="Page")
     **/
    protected $page;

    /**
     * @ORM\OneToOne(targetEntity="StyleSet", cascade={"persist", "remove"})
     **/
    protected $style_set;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getStyleSet()
    {
        return $this->style_set;
    }

    /**
     * @param mixed $style_set
     */
    public function setStyleSet($style_set)
    {
        $this->style_set = $style_set;
    }
}
