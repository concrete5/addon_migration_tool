<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportBlockValues")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="value_type", type="string")
 */
abstract class BlockValue
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\PortlandLabs\Concrete5\MigrationTool\Entity\Import\AbstractBlock", mappedBy="block_value")
     **/
    protected $block;

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
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param mixed $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }

    abstract public function getFormatter();
    abstract public function getPublisher();
    abstract public function getInspector();

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return false;
    }

}
