<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Site\Service;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateSitesRoutine extends AbstractRoutine
{

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $sites = $batch->getObjectCollection('site');

        if (!$sites) {
            return;
        }

        $typeService = \Core::make('site/type');
        $siteService = \Core::make('site');
        $mappers = \Core::make('migration/manager/mapping');

        foreach ($sites->getSites() as $site) {
            if (!$site->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($site);
                $type = $typeService->getByHandle($site->getType());
                if (is_object($type)) {
                    $theme = Theme::getByID($type->getSiteTypeThemeID());
                    $siteObject = $siteService->add($type, $theme, $site->getHandle(), $site->getName(), 'en_US');

                    $siteConfig = $siteObject->getConfigRepository();
                    $siteConfig->save('seo.canonical_url', $site->getCanonicalURL());

                    foreach ($site->getAttributes() as $attribute) {
                        $mapper = $mappers->driver('site_attribute');
                        $list = $mappers->createTargetItemList($batch, $mapper);
                        $item = new Item($attribute->getAttribute()->getHandle());
                        $targetItem = $list->getSelectedTargetItem($item);
                        if (!($targetItem instanceof UnmappedTargetItem || $targetItem instanceof IgnoredTargetItem)) {
                            $ak = $mapper->getTargetItemContentObject($targetItem);
                            if (is_object($ak)) {
                                $value = $attribute->getAttribute()->getAttributeValue();
                                $publisher = $value->getPublisher();
                                $publisher->publish($batch, $ak, $siteObject, $value);
                            }
                        }
                    }
                }
                $logger->logPublishComplete($site, $siteObject);
            } else {
                $logger->logSkipped($site);
            }
        }
    }
}
