<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ExpressEntity extends ExportItem
{
    /**
     * @ORM\Column(type="guid", nullable=false)
     */
    protected $express_entity_identifier;

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->express_entity_identifier;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($express_entity_identifier)
    {
        $this->express_entity_identifier = $express_entity_identifier;
    }

    public function getItemIdentifier()
    {
        return $this->getItemId();
    }


}
