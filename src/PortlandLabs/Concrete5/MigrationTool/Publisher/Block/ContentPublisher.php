<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ContentPublisher implements PublisherInterface
{
    public function publish(Batch $batch, $bt, Page $page, $area, BlockValue $value)
    {
        $data = $value->getRecords()->get(0)->getData();
        $inspector = \Core::make('migration/import/value_inspector', array($batch));
        $result = $inspector->inspect($data['content']);
        $data['content'] = $result->getReplacedContent();
        $b = $page->addBlock($bt, $area, $data);

        return $b;
    }
}
