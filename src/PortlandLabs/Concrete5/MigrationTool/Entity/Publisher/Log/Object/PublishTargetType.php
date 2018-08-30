<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\LoggableObject;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\AttributeKeyCategoryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\BlockTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\ComposerControlTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\JobFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\PageTemplateFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\PublishTargetTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\AttributeKeyCategoryValidator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogPublishTargetTypes")
 */
class PublishTargetType extends LoggableObject
{

    /**
     * @ORM\Column(type="string")
     */
    protected $handle;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param mixed $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

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


    public function getLogFormatter()
    {
        return new PublishTargetTypeFormatter();
    }
}
