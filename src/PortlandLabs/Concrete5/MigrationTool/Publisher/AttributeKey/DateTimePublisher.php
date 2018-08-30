<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Settings\DateTimeSettings;
use Concrete\Core\Entity\Attribute\Key\Type\DateTimeType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\DateTimeAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class DateTimePublisher extends AbstractPublisher
{
    /**
     * @param DateTimeAttributeKey $source
     */
    public function publish(AttributeKey $source, $destination)
    {
        // version 8
        $settings = new DateTimeSettings();
        $settings->setMode($source->getMode());
        return $this->publishAttribute($source, $settings, $destination);
    }
}
