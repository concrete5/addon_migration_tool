<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AddressAttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressFormatter implements TreeContentItemFormatterInterface
{
    protected $value;

    public function getBatchTreeNodeJsonObject()
    {
        $node = new \stdClass();
        $node->title = $this->value->getAttribute()->getHandle();
        $node->icon = 'fa fa-location-arrow';
        $node->children = array();
        $labels = array();
        $labels[] = array('field' => t('Address 1'), 'value' => $this->value->getAddress1());
        $labels[] = array('field' => t('Address 2'), 'value' => $this->value->getAddress2());
        $labels[] = array('field' => t('Address 3'), 'value' => $this->value->getAddress3());
        $labels[] = array('field' => t('City'), 'value' => $this->value->getCity());
        $labels[] = array('field' => t('State/Province'), 'value' => $this->value->getStateProvince());
        $labels[] = array('field' => t('Postal Code'), 'value' => $this->value->getPostalCode());
        $labels[] = array('field' => t('Country'), 'value' => $this->value->getCountry());
        foreach ($labels as $label) {
            $child = new \stdClass();
            $child->title = $label['field'];
            $child->itemvalue = $label['value'];
            $node->children[] = $child;
        }

        return $node;
    }

    /**
     * @param AddressAttributeValue $value
     */
    public function __construct(AttributeValue $value)
    {
        $this->value = $value;
    }
}
