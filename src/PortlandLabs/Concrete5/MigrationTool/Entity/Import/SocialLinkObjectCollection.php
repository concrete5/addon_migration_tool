<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\SocialLinkFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 */
class SocialLinkObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="SocialLink", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function getFormatter()
    {
        return new SocialLinkFormatter($this);
    }

    public function getType()
    {
        return 'social_link';
    }

    public function hasRecords()
    {
        return count($this->getLinks());
    }

    public function getRecords()
    {
        return $this->getLinks();
    }

    public function getTreeFormatter()
    {
        return false;
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return false;
    }
}
