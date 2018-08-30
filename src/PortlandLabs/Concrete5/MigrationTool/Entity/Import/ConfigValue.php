<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ConfigValueValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportConfigValues")
 */
class ConfigValue implements PublishableInterface, LoggableInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ConfigValueObjectCollection")
     **/
    protected $collection;

    /**
     * @ORM\Column(type="string")
     */
    protected $config_key;

    /**
     * @ORM\Column(type="text")
     */
    protected $config_value;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $package = null;

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    public function getPublisherValidator()
    {
        return new ConfigValueValidator($this);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getConfigKey()
    {
        return $this->config_key;
    }

    /**
     * @param mixed $key
     */
    public function setConfigKey($key)
    {
        $this->config_key = $key;
    }

    /**
     * @return mixed
     */
    public function getConfigValue()
    {
        return $this->config_value;
    }

    /**
     * @param mixed $value
     */
    public function setConfigValue($value)
    {
        $this->config_value = $value;
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $value = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\ConfigValue();
        $value->setConfigKey($this->getConfigKey());
        return $value;
    }
}
