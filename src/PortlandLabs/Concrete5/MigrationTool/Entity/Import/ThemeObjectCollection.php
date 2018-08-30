<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\ThemeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 */
class ThemeObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="Theme", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $themes;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
    }

    /**
     * @ORM\return mixed
     */
    public function getThemes()
    {
        return $this->themes;
    }

    public function getFormatter()
    {
        return new ThemeFormatter($this);
    }

    public function getType()
    {
        return 'theme';
    }

    public function hasRecords()
    {
        return count($this->getThemes());
    }

    public function getRecords()
    {
        return $this->getThemes();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return false;
    }
}
