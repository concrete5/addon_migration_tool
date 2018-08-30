<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Traits;

use Doctrine\ORM\Mapping as ORM;

trait StackTrait
{

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $path;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cID = 0;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * @return mixed
     */
    public function getPublishedPageID()
    {
        return $this->cID;
    }

    /**
     * @param mixed $cID
     */
    public function setPublishedPageID($cID)
    {
        $this->cID = $cID;
    }


}
