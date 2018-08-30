<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractStandardExportItem extends ExportItem
{
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $item_id;

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

    public function getItemIdentifier()
    {
        return $this->getItemId();
    }
}
