<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageFeed\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageFeed\Validator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\PageFeedFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PageFeedObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageFeed", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $feeds;

    public function __construct()
    {
        $this->feeds = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getFeeds()
    {
        return $this->feeds;
    }

    public function getFormatter()
    {
        return new PageFeedFormatter($this);
    }

    public function getType()
    {
        return 'page_feed';
    }

    public function hasRecords()
    {
        return count($this->getFeeds());
    }

    public function getRecords()
    {
        return $this->getFeeds();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new Validator($batch);
    }
}
