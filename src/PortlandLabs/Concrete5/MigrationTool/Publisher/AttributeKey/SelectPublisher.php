<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use Concrete\Core\Entity\Attribute\Key\Settings\SelectSettings;
use Concrete\Core\Entity\Attribute\Key\Type\SelectType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\SelectAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class SelectPublisher extends AbstractPublisher
{
    /**
     * @param SelectAttributeKey $source
     */
    public function publish(AttributeKey $source, $destination)
    {
        // version 8
        $settings = new SelectSettings();
        $settings->setAllowMultipleValues($source->getAllowMultipleValues());
        $settings->setAllowOtherValues($source->getAllowOtherValues());
        $settings->setDisplayOrder($source->getDisplayOrder());

        return $this->publishAttribute($source, $settings, $destination);
    }
}
