<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch;

use Concrete\Core\Application\Application;
use Concrete\Core\Entity\Site\Site;
use Concrete\Core\File\Filesystem;
use Concrete\Core\Foundation\Queue\Queue;
use Concrete\Core\Page\Single;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Queue\QueueFactory;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class BatchService
{

    protected $entityManager;
    protected $application;
    protected $filesystem;

    public function __construct(Application $application, EntityManagerInterface $entityManager, Filesystem $filesystem)
    {
        $this->application = $application;
        $this->entityManager = $entityManager;
        $this->filesystem = $filesystem;
    }

    public function clearQueues(Batch $batch)
    {
        $factory = new QueueFactory();
        if ($queue = $factory->getMapperQueue($batch)) {
            $queue->deleteQueue();
        }
        if ($queue = $factory->getTransformerQueue($batch)) {
            $queue->deleteQueue();
        }
        if ($queue = $factory->getPublisherQueue($batch)) {
            $queue->deleteQueue();
        }
    }

    public function deleteBatch(Batch $batch)
    {
        $this->clearQueues($batch);
        foreach ($batch->getObjectCollections() as $collection) {
            $this->entityManager->remove($collection);
        }
        $batch->setObjectCollections(new ArrayCollection());
        foreach ($batch->getTargetItems() as $targetItem) {
            $targetItem->setBatch(null);
            $this->entityManager->remove($targetItem);
        }
        $this->entityManager->flush();
        $this->entityManager->remove($batch);
        $this->entityManager->flush();


    }
    public function addBatch($name, Site $site = null)
    {
        $batch = new Batch();
        $batch->setName($name);
        if (!is_object($site)) {
            $site = $this->application->make('site')->getDefault();
        }
        $batch->setSite($site);
        $batch->setFileFolderID($this->filesystem->getRootFolder()->getTreeNodeID());
        $this->entityManager->persist($batch);
        $this->entityManager->flush();

        $this->createImportNode($site);

        return $batch;
    }

    public function createImportNode(Site $site)
    {
        $batches = \Page::getByPath('/!import_batches', 'RECENT', $site->getSiteTreeObject()
        );
        if (!is_object($batches) || $batches->isError()) {
            $c = Single::add('/!import_batches', \Package::getByHandle('migration_tool'), true);
            $c->update(array('cName' => 'Import Batches'));
            $c->setOverrideTemplatePermissions(1);
            $c->setAttribute('icon_dashboard', 'fa fa-cubes');
        }
    }

}