<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Value;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\SocialLinksAttributeValue;

defined('C5_EXECUTE') or die("Access Denied.");

class SocialLinksImporter extends AbstractImporter
{
    public function parse(\SimpleXMLElement $node)
    {
        $value = new SocialLinksAttributeValue();
        $links = array();
        if ($node->link) {
            foreach ($node->link as $link) {
                $links[] = array('service' => (string) $link['service'],
                    'detail' => (string) $link['detail'],
                );
            }
        }
        $value->setValue($links);

        return $value;
    }
}
