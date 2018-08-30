<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Settings\BooleanSettings;
use Concrete\Core\Entity\Attribute\Key\Type\BooleanType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\BooleanAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class BooleanPublisher extends AbstractPublisher
{
    /**
     * @param BooleanAttributeKey $source
     */
    public function publish(AttributeKey $source, $destination)
    {
        $settings = new BooleanSettings();
        $settings->setIsCheckedByDefault($source->getIsChecked());
        return $this->publishAttribute($source, $settings, $destination);
    }
}
