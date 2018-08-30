<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Export;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class CaptchaLibrary extends ExportItem
{
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $handle;

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $item_id
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    public function getItemIdentifier()
    {
        return $this->getHandle();
    }
}
