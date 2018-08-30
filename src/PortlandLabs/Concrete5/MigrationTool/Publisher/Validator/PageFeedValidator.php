<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Page\Feed;

class PageFeedValidator extends AbstractValidator
{
    public function skipItem()
    {
        $feed = Feed::getByHandle($this->object->getHandle());

        return is_object($feed);
    }
}
