<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Provider\UserProviderInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\PageType\TreeJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\Validator;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\PageTypeFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PageTypeObjectCollection extends ObjectCollection implements UserProviderInterface
{
    /**
     * @ORM\OneToMany(targetEntity="PageType", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getTypes()
    {
        return $this->types;
    }

    public function getFormatter()
    {
        return new PageTypeFormatter($this);
    }

    public function getType()
    {
        return 'page_type';
    }

    public function hasRecords()
    {
        return count($this->getTypes());
    }

    public function getRecords()
    {
        return $this->getTypes();
    }

    public function getTreeFormatter()
    {
        return new TreeJsonFormatter($this);
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new Validator($batch);
    }

    public function getUserNames()
    {
        $users = array();
        foreach ($this->getTypes() as $type) {
            $defaults = $type->getDefaultPageCollection();
            foreach ($defaults->getPages() as $page) {
                if ($page->getUser() && !in_array($page->getUser(), $users)) {
                    $users[] = $page->getUser();
                }
            }
        }
        return $users;
    }
}
