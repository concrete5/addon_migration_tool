<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeKeyCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeSetFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\ConfigValueFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeKeyCategoryValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogConfigValues")
 */
class ConfigValue extends LoggableObject
{

    /**
     * @ORM\Column(type="string")
     */
    protected $config_key;

    /**
     * @return mixed
     */
    public function getConfigKey()
    {
        return $this->config_key;
    }

    /**
     * @param mixed $config_key
     */
    public function setConfigKey($config_key)
    {
        $this->config_key = $config_key;
    }


    public function getLogFormatter()
    {
        return new ConfigValueFormatter();
    }
}
