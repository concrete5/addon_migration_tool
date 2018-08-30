<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\AttributeKeyFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeKey\Validator as AttributeKeyValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AttributeKeyObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="AttributeKey", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $keys;

    public function __construct()
    {
        $this->keys = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getKeys()
    {
        return $this->keys;
    }

    public function getFormatter()
    {
        return new AttributeKeyFormatter($this);
    }

    public function getType()
    {
        return 'attribute_key';
    }

    public function hasRecords()
    {
        return count($this->getKeys());
    }

    public function getRecords()
    {
        return $this->getKeys();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new AttributeKeyValidator($batch);
    }
}
