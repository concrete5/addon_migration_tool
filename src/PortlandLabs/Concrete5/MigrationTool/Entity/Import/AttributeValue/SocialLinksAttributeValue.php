<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute\SocialLinksFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute\SocialLinksPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportAttributeSocialLinksValues")
 */
class SocialLinksAttributeValue extends AttributeValue
{
    /**
     * @ORM\Column(type="json_array")
     */
    protected $links_value;

    public function getValue()
    {
        return $this->links_value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($links_value)
    {
        $this->links_value = $links_value;
    }

    public function getFormatter()
    {
        return new SocialLinksFormatter($this);
    }

    public function getPublisher()
    {
        return new SocialLinksPublisher();
    }
}
