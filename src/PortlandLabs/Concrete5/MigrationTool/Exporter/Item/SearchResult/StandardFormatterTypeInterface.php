<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\SearchResult;

use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

interface StandardFormatterTypeInterface
{
    public function getHandle();

    public function getHeaders();

    public function getResults(Request $request);

    public function getResultColumns(ExportItem $item);
}
