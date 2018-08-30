<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\PackageFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PackageObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Package", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $packages;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPackages()
    {
        return $this->packages;
    }

    public function getFormatter()
    {
        return new PackageFormatter($this);
    }

    public function getType()
    {
        return 'package';
    }

    public function hasRecords()
    {
        return count($this->getPackages());
    }

    public function getRecords()
    {
        return $this->getPackages();
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
