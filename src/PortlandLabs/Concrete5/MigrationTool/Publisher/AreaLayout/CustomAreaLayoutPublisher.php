<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayout;
use Concrete\Core\Area\Layout\CustomLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayoutColumn;

defined('C5_EXECUTE') or die("Access Denied.");

class CustomAreaLayoutPublisher implements PublisherInterface
{
    /**
     * @param CustomAreaLayout $layout
     */
    public function publish(AreaLayout $layout)
    {
        $arLayout = CustomLayout::add($layout->getSpacing(), $layout->getHasCustomWidths());
        foreach ($layout->getColumns() as $column) {
            /*
             * @var $column CustomAreaLayoutColumn
             */
            $columnObject = $arLayout->addLayoutColumn();
            $columnObject->setAreaLayoutColumnWidth($column->getWidth());
        }

        return $arLayout;
    }
}
