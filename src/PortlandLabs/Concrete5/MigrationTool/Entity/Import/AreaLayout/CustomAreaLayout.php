<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout\CustomAreaLayoutPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CustomAreaLayout extends AreaLayout
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $spacing = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $has_custom_widths = false;

    /**
     * @return mixed
     */
    public function getSpacing()
    {
        return $this->spacing;
    }

    /**
     * @param mixed $spacing
     */
    public function setSpacing($spacing)
    {
        $this->spacing = $spacing;
    }

    /**
     * @return mixed
     */
    public function getHasCustomWidths()
    {
        return $this->has_custom_widths;
    }

    /**
     * @param mixed $has_custom_widths
     */
    public function setHasCustomWidths($has_custom_widths)
    {
        $this->has_custom_widths = $has_custom_widths;
    }

    public function getPublisher()
    {
        return new CustomAreaLayoutPublisher();
    }
}
