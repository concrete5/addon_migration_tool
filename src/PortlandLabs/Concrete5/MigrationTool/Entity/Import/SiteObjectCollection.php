<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\SiteFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Site\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\PageFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SiteObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Site", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $sites;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param ArrayCollection $pages
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
    }

    public function getFormatter()
    {
        return new SiteFormatter($this);
    }

    public function getType()
    {
        return 'site';
    }

    public function hasRecords()
    {
        return count($this->getSites());
    }

    public function getRecords()
    {
        return $this->getSites();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return \Core::make('migration/batch/site/validator', array($batch));
    }
}
