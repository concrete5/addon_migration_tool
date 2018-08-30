<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Category;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKeyCategoryInstance;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UserAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class UserImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new UserAttributeKeyCategoryInstance();
    }

    /**
     * @param UserAttributeKeyCategoryInstance $category
     * @param \SimpleXMLElement $element
     */
    public function loadFromXml(AttributeKeyCategoryInstance $category, \SimpleXMLElement $element)
    {
        if ((string) $element['profile-displayed'] == '1') {
            $category->setDisplayedInProfile(true);
        }
        if ((string) $element['profile-editable'] == '1') {
            $category->setEditableInProfile(true);
        }
        if ((string) $element['profile-required'] == '1') {
            $category->setRequiredInProfile(true);
        }
        if ((string) $element['register-editable'] == '1') {
            $category->setEditableInRegistration(true);
        }
        if ((string) $element['register-required'] == '1') {
            $category->setRequiredInRegistration(true);
        }
        if ((string) $element['member-list-displayed'] == '1') {
            $category->setDisplayedInMemberList(true);
        }
    }
}
