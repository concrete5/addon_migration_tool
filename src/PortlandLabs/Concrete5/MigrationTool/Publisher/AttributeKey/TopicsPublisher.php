<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Key as CoreAttributeKey;
use Concrete\Core\Entity\Attribute\Key\Settings\TopicsSettings;
use Concrete\Core\Entity\Attribute\Key\Type\TopicsType;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TopicsAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsPublisher extends AbstractPublisher
{
    /**
     * @param TopicsAttributeKey $source
     * @param CoreAttributeKey $destination
     */
    public function publish(AttributeKey $source, $destination)
    {
        $name = (string) $source->getTreeName();
        $tree = \Concrete\Core\Tree\Type\Topic::getByName($name);
        $node = $tree->getNodeByDisplayPath($source->getNodePath());
        // version 8
        $settings = new TopicsSettings();
        $settings->setParentNodeID($node->getTreeNodeID());
        $settings->setTopicTreeID($tree->getTreeID());
        return $this->publishAttribute($source, $settings, $destination);
    }
}
