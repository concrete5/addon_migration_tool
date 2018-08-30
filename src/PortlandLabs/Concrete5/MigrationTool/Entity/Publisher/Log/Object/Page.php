<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeKeyCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeSetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\GroupFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\PageFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeKeyCategoryValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogPages")
 */
class Page extends LoggableObject
{

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="text")
     */
    protected $batch_path;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cID = 0;


    /**
     * @ORM\Column(type="text")
     */
    protected $original_path;

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
    public function getBatchPath()
    {
        return $this->batch_path;
    }

    /**
     * @param mixed $batch_path
     */
    public function setBatchPath($batch_path)
    {
        $this->batch_path = $batch_path;
    }

    /**
     * @return mixed
     */
    public function getOriginalPath()
    {
        return $this->original_path;
    }

    /**
     * @param mixed $original_path
     */
    public function setOriginalPath($original_path)
    {
        $this->original_path = $original_path;
    }

    public function getLogFormatter()
    {
        return new PageFormatter();
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
