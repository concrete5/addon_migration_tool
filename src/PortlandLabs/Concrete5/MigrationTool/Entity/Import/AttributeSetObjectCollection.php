<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeSet\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeSet\Validator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\AttributeSetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AttributeSetObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="AttributeSet", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $sets;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSets()
    {
        return $this->sets;
    }

    public function getFormatter()
    {
        return new AttributeSetFormatter($this);
    }

    public function getType()
    {
        return 'attribute_set';
    }

    public function hasRecords()
    {
        return count($this->getSets());
    }

    public function getRecords()
    {
        return $this->getSets();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new Validator($batch);
    }
}
