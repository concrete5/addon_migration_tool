<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\AttributeKeyCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AttributeKeyCategoryObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategory", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getFormatter()
    {
        return new AttributeKeyCategoryFormatter($this);
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getType()
    {
        return 'attribute_key_category';
    }

    public function hasRecords()
    {
        return count($this->getCategories());
    }

    public function getRecords()
    {
        return $this->getCategories();
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
