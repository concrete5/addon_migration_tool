<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Site;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Site;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeSiteJsonFormatter implements \JsonSerializable
{
    protected $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function jsonSerialize()
    {
        $nodes = array();
        $site = $this->site;
        $collection = $site->getCollection();
        $r = \Database::connection()->getEntityManager()->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');

        $batch = $r->findFromCollection($collection);
        $validator = $collection->getRecordValidator($batch);
        $messages = $validator->validate($site);
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

        if ($site->getAttributes()->count()) {
            $attributeHolderNode = new \stdClass();
            $attributeHolderNode->icon = 'fa fa-cogs';
            $attributeHolderNode->title = t('Attributes');
            $attributeHolderNode->children = array();
            foreach ($site->getAttributes() as $attribute) {
                $value = $attribute->getAttribute()->getAttributeValue();
                if (is_object($value)) {
                    $attributeFormatter = $value->getFormatter();
                    $attributeNode = $attributeFormatter->getBatchTreeNodeJsonObject();
                    $attributeHolderNode->children[] = $attributeNode;
                }
            }
            $nodes[] = $attributeHolderNode;
        }

        return $nodes;
    }
}
