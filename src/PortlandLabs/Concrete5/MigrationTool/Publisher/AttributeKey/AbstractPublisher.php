<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKey;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Attribute\Type;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Core\Entity\Attribute\Key\Settings\Settings;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class AbstractPublisher implements PublisherInterface
{
    protected function publishAttribute(AttributeKey $source, Settings $settings, Key $destination)
    {
        $em = \ORM::entityManager();
        $type = Type::getByHandle($source->getType());
        $destination->setAttributeType($type);

        $em->persist($destination);
        $em->flush();

        $settings->setAttributeKey($destination);
        $destination->setAttributeKeySettings($settings);

        $em->persist($settings);
        $em->flush();

        // Modify the category's search indexer.
        $category = $source->getCategory()->getAttributeController();
        $indexer = $category->getSearchIndexer();
        if (is_object($indexer)) {
            $indexer->updateRepositoryColumns($category, $destination);
        }

        $em->persist($destination);
        $em->flush();

        return $destination;
    }
}
