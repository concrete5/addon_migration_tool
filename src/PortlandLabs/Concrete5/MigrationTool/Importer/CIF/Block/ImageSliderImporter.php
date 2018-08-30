<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\ImageSliderBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockDataRecord;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageSliderImporter extends StandardImporter
{

    public function createBlockValueObject()
    {
        return new ImageSliderBlockValue();
    }
}
