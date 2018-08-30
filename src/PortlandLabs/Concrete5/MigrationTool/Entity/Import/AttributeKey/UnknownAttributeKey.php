<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportUnknownKeys")
 */
class UnknownAttributeKey extends AttributeKey
{
    /**
     * @ORM\Column(type="text")
     */
    protected $options_xml = false;

    /**
     * @return mixed
     */
    public function getOptionsXml()
    {
        return $this->options_xml;
    }

    /**
     * @param mixed $options_xml
     */
    public function setOptionsXml($options_xml)
    {
        $this->options_xml = $options_xml;
    }

    public function getType()
    {
        return 'unknown';
    }
}
