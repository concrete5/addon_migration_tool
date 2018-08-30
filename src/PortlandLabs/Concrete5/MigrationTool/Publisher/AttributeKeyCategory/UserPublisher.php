<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Key\UserKey;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UserAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class UserPublisher implements PublisherInterface
{
    public function publish(AttributeKey $ak, Package $pkg = null)
    {
        $key = new \Concrete\Core\Entity\Attribute\Key\UserKey();
        $key->setAttributeKeyHandle($ak->getHandle());
        $key->setAttributeKeyName($ak->getName());
        $key->setIsAttributeKeyInternal($ak->getIsInternal());
        $key->setIsAttributeKeyContentIndexed($ak->getIsIndexed());
        $key->setIsAttributeKeySearchable($ak->getIsSearchable());
        $key->setAttributeKeyDisplayedOnProfile($category->getDisplayedInProfile());
        $key->setAttributeKeyEditableOnProfile($category->getEditableInProfile());
        $key->setAttributeKeyRequiredOnProfile($category->getRequiredInProfile());
        $key->setAttributeKeyEditableOnRegister($category->getEditableInRegistration());
        $key->setAttributeKeyRequiredOnRegister($category->getRequiredInRegistration());
        $key->setAttributeKeyDisplayedOnMemberList($category->getDisplayedInMemberList());
        return $key;
    }
}
