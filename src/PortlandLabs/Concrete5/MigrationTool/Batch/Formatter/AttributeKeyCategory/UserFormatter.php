<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKeyCategory;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\UserAttributeKeyCategoryInstance;

defined('C5_EXECUTE') or die("Access Denied.");

class UserFormatter implements TreeContentItemFormatterInterface
{
    protected $category;

    public function __construct(UserAttributeKeyCategoryInstance $category)
    {
        $this->category = $category;
    }

    protected function addBooleanNode(\stdClass $parent, $label, $value)
    {
        $node = new \stdClass();
        $node->title = $label;
        $node->itemvalue = $value ? t('Yes') : t('No');
        $parent->children[] = $node;
    }

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Category');
        $node->itemvalue = t('User');
        $this->addBooleanNode($node, t('Displayed in Profile'), $this->category->getDisplayedInProfile());
        $this->addBooleanNode($node, t('Editable in Profile'), $this->category->getEditableInProfile());
        $this->addBooleanNode($node, t('Required in Profile'), $this->category->getRequiredInProfile());
        $this->addBooleanNode($node, t('Editable in Registration'), $this->category->getEditableInRegistration());
        $this->addBooleanNode($node, t('Required in Registration'), $this->category->getRequiredInRegistration());
        $this->addBooleanNode($node, t('Displayed in Member List'), $this->category->getDisplayedInMemberList());

        return $node;
    }
}
