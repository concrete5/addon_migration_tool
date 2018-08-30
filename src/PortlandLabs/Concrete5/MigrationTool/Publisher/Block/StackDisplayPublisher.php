<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use Concrete\Core\Page\Stack\Stack;
use Concrete\Core\Sharing\SocialNetwork\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StackDisplayBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class StackDisplayPublisher implements PublisherInterface
{
    /**
     * @param Batch $batch
     * @param $bt
     * @param Page $page
     * @param $area
     * @param StackDisplayBlockValue $value
     * @return mixed
     */
    public function publish(Batch $batch, $bt, Page $page, $area, BlockValue $value)
    {
        $data = array();
        $data['stID'] = 0;
        if ($value->getStackPath()) {
            $stack = Stack::getByPath($value->getStackPath());
            if (!is_object($stack)) {
                $stack = Stack::getByName($value->getStackPath());
            }
            if (is_object($stack)) {
                $data['stID'] = $stack->getCollectionID();
                $b = $page->addBlock($bt, $area, $data);
                return $b;
            }
        }
    }
}
