<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\ExpressEntryValidator;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\GroupValidator;
use Doctrine\ORM\Mapping as ORM;
use Concrete\Core\Entity\Express\Entity as CoreExpressEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportExpressAssociatedEntries")
 */
class AssociatedEntry
{

    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $importID;

    /**
     * @ORM\ManyToOne(targetEntity="EntryAssociation")
     **/
    protected $association;

    /**
     * @return mixed
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * @param mixed $association
     */
    public function setAssociation($association)
    {
        $this->association = $association;
    }



    /**
     * @return mixed
     */
    public function getImportID()
    {
        return $this->importID;
    }

    /**
     * @param mixed $importID
     */
    public function setImportID($importID)
    {
        $this->importID = $importID;
    }



}
