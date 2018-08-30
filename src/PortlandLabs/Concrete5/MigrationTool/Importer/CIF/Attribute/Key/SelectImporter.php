<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\SelectAttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectImporter implements ImporterInterface
{
    public function getEntity()
    {
        return new SelectAttributeKey();
    }

    public function loadFromXml(AttributeKey $key, \SimpleXMLElement $element)
    {
        $allow_multiple_values = (string) $element->type['allow-multiple-values'];
        $allow_other_values = (string) $element->type['allow-other-values'];
        $key->setDisplayOrder((string) $element->type['display-order']);
        if ($allow_multiple_values == '1') {
            $key->setAllowMultipleValues(true);
        } else {
            $key->setAllowMultipleValues(false);
        }
        if ($allow_other_values == '1') {
            $key->setAllowOtherValues(true);
        } else {
            $key->setAllowOtherValues(false);
        }
        $options = array();
        if (isset($element->type->options)) {
            foreach ($element->type->options->children() as $option) {
                $options[] = array('value' => (string) $option['value'],
                    'added' => (string) $option['is-end-user-added'], );
            }
        }
        $key->setOptions($options);
    }
}
