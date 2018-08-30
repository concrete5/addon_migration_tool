<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\User;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\User;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeUserJsonFormatter implements \JsonSerializable
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize()
    {
        $nodes = array();
        $user = $this->user;
        $collection = $user->getCollection();
        $r = \Database::connection()->getEntityManager()->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');

        $batch = $r->findFromCollection($collection);
        $validator = $collection->getRecordValidator($batch);
        $messages = $validator->validate($user);
        if ($messages->count()) {
            $messageHolderNode = new \stdClass();
            $messageHolderNode->icon = $messages->getFormatter()->getCollectionStatusIconClass();
            $messageHolderNode->title = t('Errors');
            $messageHolderNode->children = array();
            foreach ($messages as $m) {
                $messageNode = new \stdClass();
                $messageNode->icon = $m->getFormatter()->getIconClass();
                $messageNode->title = $m->getFormatter()->output();
                $messageHolderNode->children[] = $messageNode;
            }
            $nodes[] = $messageHolderNode;
        }

        $detailsHolderNode = new \stdClass();
        $detailsHolderNode->icon = 'fa fa-user';
        $detailsHolderNode->title = t('Details');
        $detailsHolderNode->children = array();

        $detailNode = new \stdClass();
        $detailNode->title = t('Username');
        $detailNode->itemvalue = $user->getName();
        $detailsHolderNode->children[] = $detailNode;

        $detailNode = new \stdClass();
        $detailNode->title = t('Email');
        $detailNode->itemvalue = $user->getEmail();
        $detailsHolderNode->children[] = $detailNode;

        $detailNode = new \stdClass();
        $detailNode->title = t('Active');
        $detailNode->itemvalue = $user->getIsActive() ? t('Yes') : t('No');
        $detailsHolderNode->children[] = $detailNode;

        $detailNode = new \stdClass();
        $detailNode->title = t('Validated');
        $detailNode->itemvalue = $user->getIsValidated() ? t('Yes') : t('No');
        $detailsHolderNode->children[] = $detailNode;

        $detailNode = new \stdClass();
        $detailNode->title = t('Timezone');
        $detailNode->itemvalue = $user->getTimezone();
        $detailsHolderNode->children[] = $detailNode;

        $detailNode = new \stdClass();
        $detailNode->title = t('Language');
        $detailNode->itemvalue = $user->getLanguage();
        $detailsHolderNode->children[] = $detailNode;

        $nodes[] = $detailsHolderNode;

        if ($user->getAttributes()->count()) {
            $attributeHolderNode = new \stdClass();
            $attributeHolderNode->icon = 'fa fa-cogs';
            $attributeHolderNode->title = t('Attributes');
            $attributeHolderNode->children = array();
            foreach ($user->getAttributes() as $attribute) {
                $value = $attribute->getAttribute()->getAttributeValue();
                if (is_object($value)) {
                    $attributeFormatter = $value->getFormatter();
                    $attributeNode = $attributeFormatter->getBatchTreeNodeJsonObject();
                    $attributeHolderNode->children[] = $attributeNode;
                }
            }
            $nodes[] = $attributeHolderNode;
        }

        if ($user->getGroups()->count()) {
            $groupHolderNode = new \stdClass();
            $groupHolderNode->icon = 'fa fa-users';
            $groupHolderNode->title = t('Groups');
            $groupHolderNode->children = array();
            foreach ($user->getGroups() as $group) {
                $groupNode = new \stdClass();
                if ($group->getPath()) {
                    $groupNode->title = $group->getPath();
                } else {
                    $groupNode->title = $group->getName();
                }
                $groupHolderNode->children[] = $groupNode;
            }
            $nodes[] = $groupHolderNode;
        }


        return $nodes;
    }
}
