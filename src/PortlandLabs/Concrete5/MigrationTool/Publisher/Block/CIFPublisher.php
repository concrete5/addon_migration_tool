<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFPublisher implements PublisherInterface
{
    public function publish(Batch $batch, $bt, Page $page, $area, BlockValue $value)
    {
        $btc = $bt->getController();
        $bx = simplexml_load_string($value->getValue());

        return $btc->import($page, $area, $bx);
    }
}
