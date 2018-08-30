<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Entity\Attribute\Key\Settings\TextareaSettings;
use Concrete\Core\Entity\Attribute\Key\Type\TextareaType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TextAreaAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TextAreaPublisher extends AbstractPublisher
{
    /**
     * @param TextAreaAttributeKey $source
     */
    public function publish(AttributeKey $source, $destination)
    {
        // version 8
        $settings = new TextareaSettings();
        $settings->setMode($source->getMode());
        return $this->publishAttribute($source, $settings, $destination);
    }
}
