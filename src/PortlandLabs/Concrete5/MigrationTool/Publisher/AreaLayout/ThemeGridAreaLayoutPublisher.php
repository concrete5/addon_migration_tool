<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AreaLayout;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;
use Concrete\Core\Area\Layout\ThemeGridLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayout;

defined('C5_EXECUTE') or die("Access Denied.");

class ThemeGridAreaLayoutPublisher implements PublisherInterface
{
    /**
     * @param ThemeGridAreaLayout $layout
     */
    public function publish(AreaLayout $layout)
    {
        $arLayout = ThemeGridLayout::add();
        foreach ($layout->getColumns() as $column) {
            /*
             * @var $column ThemeGridAreaLayoutColumn
             */
            $columnObject = $arLayout->addLayoutColumn();
            $columnObject->setAreaLayoutColumnSpan($column->getSpan());
            $columnObject->setAreaLayoutColumnOffset($column->getOffset());
        }

        return $arLayout;
    }
}
