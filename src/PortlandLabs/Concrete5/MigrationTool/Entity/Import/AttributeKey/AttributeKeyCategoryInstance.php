<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;
use Concrete\Core\Attribute\Key\Category;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="MigrationImportAttributeKeyCategoryInstances")
 */
abstract class AttributeKeyCategoryInstance
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="AttributeKey", mappedBy="category")
     **/
    protected $key;

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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    abstract public function getHandle();

    /**
     * @return \PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\PublisherInterface
     */
    abstract public function getPublisher();

    public function __toString()
    {
        return $this->getHandle();
    }

    public function getAttributeController()
    {
        return Category::getByHandle($this->getHandle())
            ->getController();
    }
}
