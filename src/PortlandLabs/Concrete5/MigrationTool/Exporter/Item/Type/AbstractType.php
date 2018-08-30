<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch;
use PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Exporter;
use PortlandLabs\Concrete5\MigrationTool\Exporter\Item\SearchResult\StandardFormatter;
use PortlandLabs\Concrete5\MigrationTool\Exporter\Item\SearchResult\StandardFormatterTypeInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractType implements TypeInterface, StandardFormatterTypeInterface
{
    public function __construct()
    {
        $this->exporter = new Exporter();
    }

    public function getResultsFormatter(Batch $batch)
    {
        return new StandardFormatter($this, $batch);
    }
}
