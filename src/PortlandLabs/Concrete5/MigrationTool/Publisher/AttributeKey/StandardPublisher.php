<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Controller;
use Concrete\Core\Attribute\Type;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class StandardPublisher extends AbstractPublisher
{
    public function publish(AttributeKey $source, $destination)
    {
        $type = Type::getByHandle($source->getType());
        if ($type) {
            $controller = $type->getController();
            // version 8
            $settings = $controller->getAttributeKeySettings();
            return $this->publishAttribute($source, $settings, $destination);
        }
    }
}
