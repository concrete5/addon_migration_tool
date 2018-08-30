<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Block\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block\ImageSliderValidator;
use PortlandLabs\Concrete5\MigrationTool\Inspector\Block\StandardInspector;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Block\Manager;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Table(name="MigrationImportImageSliderBlockValues")
 * @ORM\Entity
 */
class ImageSliderBlockValue extends StandardBlockValue
{

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new ImageSliderValidator();
    }

    public function getPublisher()
    {
        $manager = \Core::make('migration/manager/publisher/block');
        return $manager->driver('image_slider');
    }

}
