<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Block;

use Concrete\Core\Page\Stack\Stack;
use Concrete\Core\Sharing\SocialNetwork\Link;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\BlockValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StackDisplayBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageSliderPublisher implements PublisherInterface
{

    protected function getBaseSlideshowRecord(BlockValue $value)
    {
        $records = $value->getRecords();
        foreach($records as $record) {
            if ($record->getTable() == 'btSlideshow') {
                return $record;
            }
        }
    }

    protected function isMigratingFromSlideshow(BlockValue $value)
    {
        $record = $this->getBaseSlideshowRecord($value);
        return $record != null;
    }

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
        if ($this->isMigratingFromSlideshow($value)) {
            $inspector = \Core::make('migration/import/value_inspector', array($batch));

            // handle the base table.
            $record = $this->getBaseSlideshowRecord($value);
            $oldData = $record->getData();
            if ($oldData['duration']) {
                $timeout = $oldData['duration'] * 1000;
            } else {
                $timeout = 4000;
            }

            if ($oldData['fadeDuration']) {
                $speed = $oldData['fadeDuration'] * 1000;
            } else {
                $speed = 500;
            }

            $data = [
                'navigationType' => 1,
                'timeout' => $timeout,
                'speed' => $speed,
                'noAnimate' => false,
                'pause' => 1,
                'maxWidth' => 0,
            ];

            $i = 0;
            foreach($value->getRecords() as $record) {
                if ($record->getTable() == 'btSlideshowImg') {

                    $recordData = $record->getData();
                    $result = $inspector->inspect($recordData['fID']);


                    $data['sortOrder'][] = $i;
                    $data['fID'][$i] = $result->getReplacedValue();
                    if ($recordData['url']) {
                        $data['linkType'] = 2;
                        $data['linkURL'] = $recordData['url'];
                    } else {
                        $data['linkType'] = 0;
                    }
                    $data['description'][$i] = '';
                    $data['sortOrder'][$i] = $i;
                    $i++;
                }
            }

            $b = $page->addBlock($bt, $area, $data);
            return $b;

        } else {
            $publisher = new StandardPublisher();
            return $publisher->publish($batch, $bt, $page, $area, $value);
        }
    }
}
