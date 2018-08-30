<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Sharing\SocialNetwork\Link;

class SocialLinkValidator extends AbstractValidator
{
    public function skipItem()
    {
        $site = $this->getBatch($this->object)->getSite();
        $link = Link::getByServiceHandle($this->object->getService(), $site);
        return is_object($link);
    }
}
