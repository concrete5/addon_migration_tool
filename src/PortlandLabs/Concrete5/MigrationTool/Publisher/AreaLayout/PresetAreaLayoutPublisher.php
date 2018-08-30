<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use Concrete\Core\Area\Layout\Preset\Preset;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayout;
use Concrete\Core\Area\Layout\PresetLayout;

defined('C5_EXECUTE') or die("Access Denied.");

class PresetAreaLayoutPublisher implements PublisherInterface
{
    /**
     * @param PresetAreaLayout $layout
     */
    public function publish(AreaLayout $layout)
    {
        $preset = Preset::getByID($layout->getPreset());
        $arLayout = PresetLayout::add($preset);
        foreach ($layout->getColumns() as $column) {
            $arLayout->addLayoutColumn();
        }

        return $arLayout;
    }
}
