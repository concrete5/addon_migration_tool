<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Block;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ItemValidatorInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\StandardBlockValue;

defined('C5_EXECUTE') or die("Access Denied.");

class ImageSliderValidator implements ItemValidatorInterface
{
    /**
     * @param $value StandardBlockValue
     * @return MessageCollection
     */
    public function validate($value)
    {
        $messages = new MessageCollection();
        $record = $value->getRecords()[0];
        if ($record) {
            $data = $record->getData();
            if (isset($data['fsID']) && $data['fsID'] > 0) {
                $page = $value->getBlock()->getArea()->getPage();
                $messages->add(new Message(t('Slideshow block on page "%s" uses a file set for display. This will not migrate properly.', $page->getName())));
            }
        }

        return $messages;
    }
}
