<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractEntryFormatter implements FormatterInterface
{

    /**
     * @var \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry
     */
    protected $entry;

    /**
     * AbstractEntryFormatter constructor.
     * @param \PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry $entry
     */
    public function __construct(\PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Entry $entry)
    {
        $this->entry = $entry;
    }


}
