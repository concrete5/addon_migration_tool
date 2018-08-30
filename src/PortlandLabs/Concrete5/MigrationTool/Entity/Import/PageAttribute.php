<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportPageAttributes")
 */
class PageAttribute implements LoggableInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Attribute", cascade={"persist", "remove"})
     **/
    protected $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="Page")
     **/
    protected $page;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $object = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\PageAttribute();
        $object->setHandle($this->getAttribute()->getHandle());;
        $object->setPage($this->getPage()->getName());
        return $object;
    }

}
