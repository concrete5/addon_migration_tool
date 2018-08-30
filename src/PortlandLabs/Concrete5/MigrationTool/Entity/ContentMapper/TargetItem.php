<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationContentMapperTargetItems")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="entity_type", type="string")
 */
class TargetItem implements TargetItemInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $source_item_identifier;

    /**
     * @ORM\Column(type="string")
     */
    protected $item_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $item_type;

    protected $item_name;

    public function __construct(MapperInterface $mapper = null)
    {
        if ($mapper) {
            $this->item_type = $mapper->getHandle();
        }
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getItemType()
    {
        return $this->item_type;
    }

    /**
     * @param mixed $item_type
     */
    public function setItemType($item_type)
    {
        $this->item_type = $item_type;
    }

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * @param mixed $item_name
     */
    public function setItemName($item_name)
    {
        $this->item_name = $item_name;
    }

    /**
     * @return mixed
     */
    public function getSourceItemIdentifier()
    {
        return $this->source_item_identifier;
    }

    /**
     * @param mixed $source_item_identifier
     */
    public function setSourceItemIdentifier($source_item_identifier)
    {
        $this->source_item_identifier = $source_item_identifier;
    }

    public function matches(TargetItemInterface $targetItem)
    {
        return (string) $this->getItemId() == (string) $targetItem->getItemId();
    }

    public function isMapped()
    {
        return true;
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
        }
    }

}
