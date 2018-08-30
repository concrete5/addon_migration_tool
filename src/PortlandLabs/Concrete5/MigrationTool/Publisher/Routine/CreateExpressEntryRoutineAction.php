<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Attribute\Key\Category;
use Concrete\Core\Utility\Service\Identifier;
use PortlandLabs\CalendarImport\Entity\Import\Event;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item\Item;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Entry;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\EntryAssociation;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\User;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\AbstractPageAction;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\AbstractPageRoutine;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\RoutineActionInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Routine\RoutineInterface;
use PortlandLabs\CalendarImport\Entity\Import\BatchSettings;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\TargetItemList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object\Page as LogPage;

defined('C5_EXECUTE') or die("Access Denied.");

class CreateExpressEntryRoutineAction implements RoutineActionInterface
{

    protected $entry;
    protected $entryID;

    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
        $this->entryID = $entry->getID();
    }

    public function __sleep()
    {
        return array('entryID');
    }

    public function __wakeup()
    {
        $this->populateEntry($this->entryID);
    }

    public function populateEntry($id)
    {
        $entityManager = \Database::connection()->getEntityManager();
        $r = $entityManager->getRepository(Entry::class);
        $this->entry = $r->findOneById($id);
    }

    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $entityManager = \Database::connection()->getEntityManager();

        $entry = $this->entry;

        $logger->logPublishStarted($entry);

        $publishedEntity = \Express::getObjectByHandle($entry->getEntity());
        $publishedEntry = new \Concrete\Core\Entity\Express\Entry();
        $publishedEntry->setEntity($publishedEntity);

        $entityManager->persist($publishedEntry);
        $entityManager->flush();

        $mappers = \Core::make('migration/manager/mapping');

        foreach ($entry->getAttributes() as $attribute) {
            $mapper = $mappers->driver('express_attribute');
            $list = $mappers->createTargetItemList($batch, $mapper);
            $item = new Item($entry->getEntity() . '|' . $attribute->getAttribute()->getHandle());
            $targetItem = $list->getSelectedTargetItem($item);
            if (!($targetItem instanceof UnmappedTargetItem || $targetItem instanceof IgnoredTargetItem)) {
                $ak = $mapper->getTargetItemContentObject($targetItem);
                if (is_object($ak)) {
                    $value = $attribute->getAttribute()->getAttributeValue();
                    $publisher = $value->getPublisher();
                    $publisher->publish($batch, $ak, $publishedEntry, $value);
                }
            }
        }

        $logger->logPublishComplete($entry, $publishedEntry);
    }

}
