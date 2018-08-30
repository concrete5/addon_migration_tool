<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Permission\Key\Key;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePermissionsRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $keys = $batch->getObjectCollection('permission_key');

        if (!$keys) {
            return;
        }

        foreach ($keys->getKeys() as $key) {
            if (!$key->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($key);
                $pkg = null;
                if ($key->getPackage()) {
                    $pkg = \Package::getByHandle($key->getPackage());
                }
                $p = Key::add($key->getCategory(), $key->getHandle(), $key->getName(), $key->getDescription(), $key->getCanTriggerWorkflow(), $key->getHasCustomClass(),  $pkg);
                foreach ($key->getAccessEntities() as $entity) {
                    $publisher = $entity->getPublisher();
                    $publisher->publish($p, $entity);
                }
                $logger->logPublishComplete($key);
            } else {
                $logger->logSkipped($key);
            }
        }
    }
}
