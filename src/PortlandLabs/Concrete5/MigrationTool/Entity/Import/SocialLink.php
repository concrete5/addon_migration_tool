<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\SocialLinkValidator;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportSocialLinks")
 */
class SocialLink implements PublishableInterface, LoggableInterface
{

    use \PortlandLabs\Concrete5\MigrationTool\Entity\Traits\SocialLink;

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\ManyToOne(targetEntity="SocialLinkObjectCollection")
     **/
    protected $collection;

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


    public function getPublisherValidator()
    {
        return new SocialLinkValidator($this);
    }

    public function __clone()
    {
        if ($this->id) {
            $this->id = null;
            $this->collection = null;
        }
    }

    public function createPublisherLogObject($publishedObject = null)
    {
        $object = new \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\SocialLink();
        $object->setService($this->getService());
        $object->setUrl($this->getUrl());
        $object->setLink($publishedObject);
        return $object;
    }
}
