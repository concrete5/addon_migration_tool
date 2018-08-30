<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationExportObjectCollections")
 */
class ObjectCollection
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\OneToMany(targetEntity="ExportItem", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function hasRecords()
    {
        return $this->items->count() > 0;
    }

    public function getItemTypeObject()
    {
        $exporters = \Core::make('migration/manager/exporters');

        return $exporters->driver($this->getType());
    }

    public function contains(ExportItem $item)
    {
        foreach ($this->getItems() as $existingItem) {
            if ($existingItem->getItemIdentifier() == $item->getItemIdentifier()) {
                return true;
            }
        }

        return false;
    }
}
