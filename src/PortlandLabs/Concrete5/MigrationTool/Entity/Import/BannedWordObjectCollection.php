<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection\BannedWordFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BannedWordObjectCollection extends ObjectCollection
{
    /**
     * @ORM\OneToMany(targetEntity="BannedWord", mappedBy="collection", cascade={"persist", "remove"})
     **/
    public $words;

    public function __construct()
    {
        $this->words = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getWords()
    {
        return $this->words;
    }

    public function getFormatter()
    {
        return new BannedWordFormatter($this);
    }

    public function getType()
    {
        return 'banned_word';
    }

    public function hasRecords()
    {
        return count($this->getWords());
    }

    public function getRecords()
    {
        return $this->getWords();
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
