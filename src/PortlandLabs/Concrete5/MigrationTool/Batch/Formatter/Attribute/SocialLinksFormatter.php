<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SocialLinksAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksFormatter implements TreeContentItemFormatterInterface
{
    protected $value;

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = t('Social Links');
        $node->icon = 'fa fa-link';
        $node->children = array();
        foreach ($this->value->getValue() as $links) {
            $child = new \stdClass();
            $child->itemvalue = $links['detail'];
            $child->title = $links['service'];
            $node->children[] = $child;
        }

        return $node;
    }

    /**
     * @param SocialLinksAttributeValue $value
     */
    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }
}
