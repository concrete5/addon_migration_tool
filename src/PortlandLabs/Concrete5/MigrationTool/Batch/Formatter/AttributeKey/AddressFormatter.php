<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressFormatter extends AbstractFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        /** @var $key \PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AddressAttributeKey */
        $key = $this->key;

        $nodes = array();

        $node = new \stdClass();
        $node->title = t('Has Custom Countries');
        $node->itemvalue = $key->getHasCustomCountries() ? t('Yes') : t('No');
        $nodes[] = $node;

        $node = new \stdClass();
        $node->title = t('Default Country');
        $node->itemvalue = $key->getDefaultCountry();
        $nodes[] = $node;

        if (count($key->getCustomCountries())) {
            $node = new \stdClass();
            $node->title = t('Custom Countries');
            $node->children = array();

            foreach ($key->getCustomCountries() as $country) {
                $child = new \stdClass();
                $child->title = $country;
                $node->children[] = $child;
            }

            $nodes[] = $node;
        }

        return $this->deliverTreeNodeDataJsonObject($nodes);
    }
}
