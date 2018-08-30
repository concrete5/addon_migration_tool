<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration;

use Concrete\Core\Application\EditResponse;
use Concrete\Core\File\File;
use Concrete\Core\Page\Controller\DashboardSitePageController;
use Concrete\Package\MigrationTool\Page\Controller\DashboardPageController;
use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Exporter\Exporter;
use Symfony\Component\HttpFoundation\JsonResponse;

class Export extends DashboardSitePageController
{
    public function add_batch()
    {
        if (!$this->token->validate('add_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $batch = new Batch();
            $batch->setName($this->request->request->get('name'));
            $this->entityManager->persist($batch);
            $this->entityManager->flush();
            $this->flash('success', t('Batch added successfully.'));
            $this->redirect('/dashboard/system/migration/export', 'view_batch', $batch->getId());
        }
        $this->view();
    }

    public function delete_batch()
    {
        if (!$this->token->validate('delete_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
            $batch = $r->findOneById($this->request->request->get('id'));
            if (is_object($batch)) {
                foreach ($batch->getObjectCollections() as $collection) {
                    $this->entityManager->remove($collection);
                }
                $batch->setObjectCollections(new ArrayCollection());
                $this->entityManager->flush();
                $this->entityManager->remove($batch);
                $this->entityManager->flush();
                $this->flash('success', t('Batch removed successfully.'));
                $this->redirect('/dashboard/system/migration/export');
            }
        }
        $this->view();
    }

    public function view()
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batches = $r->findAll(array(), array('date' => 'desc'));
        $this->set('batches', $batches);
        $this->set('batchType', 'export');
        $this->set('sites', $this->app->make('site')->getList());
        $this->set('batchEmptyMessage', t('You have not created any export batches.'));
        $this->render('/dashboard/system/migration/view_batches');
    }

    public function view_batch($id = null)
    {
        $this->requireAsset('migration/view-batch');
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Export Batch'));
            $this->render('/dashboard/system/migration/view_export_batch');
        } else {
            $this->view();
        }
    }

    public function export_batch($id = null)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $exporter = new Exporter($batch);
            $files = $exporter->getReferencedFiles();
            $this->set('files', $files);
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Export Batch'));
            $this->render('/dashboard/system/migration/finalize_export_batch');
        } else {
            $this->view();
        }
    }

    public function download_files()
    {
        @ini_set('memory_limit', '-1');
        @set_time_limit(0);
        $id = $_POST['id'];
        if ($id) {
            $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
            $batch = $r->findOneById($id);
        }
        if (!is_object($batch)) {
            $this->error->add(t('Invalid Batch'));
        }
        if (!$this->token->validate('download_files')) {
            $this->error->add($this->token->getErrorMessage());
        }
        $fh = \Loader::helper('file');
        $vh = \Loader::helper('validation/identifier');
        if (!$this->error->has()) {
            $temp = sys_get_temp_dir();
            if (!$temp) {
                $temp = $fh->getTemporaryDirectory();
            }
            $filename = $temp.'/'.$vh->getString().'.zip';
            $files = array();
            $prefixes = array();
            foreach ((array) $_POST['batchFileID'] as $fID) {
                $f = File::getByID(intval($fID));
                if (!$r) {
                    continue;
                }
                $fp = new \Permissions($f);
                if ($fp->canRead()) {
                    $files[] = $f;
                    $prefixes[] = $f->getPrefix();
                }
            }
            if (empty($files)) {
                throw new \Exception(t('None of the requested files could be found.'));
            }
            if (class_exists('ZipArchive', false)) {
                $zip = new \ZipArchive();
                $res = $zip->open($filename, \ZipArchive::CREATE);
                if ($res !== true) {
                    throw new \Exception(t('Could not open with ZipArchive::CREATE'));
                }
                for ($i = 0; $i < count($files); $i++) {
                    $f = $files[$i];
                    $prefix = $prefixes[$i];
                    $zip->addFromString($prefix . '_' . $f->getFilename(), $f->getFileContents());
                }
                $zip->close();
            } else {
                throw new \Exception(t('You must enable ZipArchive to download files.'));
            }
            $fh->forceDownload($filename);
        }
        exit;
    }

    public function export_batch_xml($id = null)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $exporter = new Exporter($batch);
            if ($this->request->request->get('download')) {
                header('Content-disposition: attachment; filename="export.xml"');
                header('Content-type: "text/xml"; charset="utf8"');
            } else {
                header('Content-type: text/xml');
            }
            echo $exporter->getElement()->asXML();
            exit;
        } else {
            $this->view();
        }
    }

    public function add_items_to_batch()
    {
        if (!$this->token->validate('add_items_to_batch')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $exporters = \Core::make('migration/manager/exporters');
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batch = $r->findOneById($this->request->request->get('batch_id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        $selectedItemType = false;
        if ($this->request->request->has('item_type') && $this->request->request->get('item_type')) {
            $selectedItemType = $exporters->driver($this->request->request->get('item_type'));
        }
        if (!is_object($selectedItemType)) {
            $this->error->add(t('Invalid item type.'));
        }

        if (!$this->error->has()) {
            $values = $this->request->request->get('id');
            $exportItems = $selectedItemType->getItemsFromRequest($values[$selectedItemType->getHandle()]);
            $collection = $batch->getObjectCollection($selectedItemType->getHandle());
            if (!is_object($collection)) {
                $collection = new ObjectCollection();
                $collection->setType($selectedItemType->getHandle());
                $batch->getObjectCollections()->add($collection);
            }
            foreach ($exportItems as $item) {
                if (!$collection->contains($item)) {
                    $item->setCollection($collection);
                    $collection->getItems()->add($item);
                }
            }

            $this->entityManager->persist($batch);
            $this->entityManager->flush();
            $response = new JsonResponse($exportItems);

            return $response;
        }

        $r = new EditResponse();
        $r->setError($this->error);
        $r->outputJSON();
    }

    public function remove_batch_items()
    {
        if (!$this->token->validate('remove_batch_items')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $exporters = \Core::make('migration/manager/exporters');
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batch = $r->findOneById($this->request->request->get('batch_id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        if (!$this->error->has()) {
            $values = $this->request->request->get('id');
            foreach ($values as $item_type => $ids) {
                $collection = $batch->getObjectCollection($item_type);
                if (is_object($collection)) {
                    foreach ($collection->getItems() as $item) {
                        if (in_array($item->getItemIdentifier(), $ids)) {
                            $this->entityManager->remove($item);
                        }
                    }
                }
            }

            $this->entityManager->flush();

            // Now we make sure no empty object collections remain.
            $collections = $batch->getObjectCollections();
            $batch->setObjectCollections(new ArrayCollection());
            foreach ($collections as $collection) {
                if (!$collection->hasRecords()) {
                    $this->entityManager->remove($collection);
                } else {
                    $batch->getObjectCollections()->add($collection);
                }
            }

            $this->entityManager->persist($batch);
            $this->entityManager->flush();

            $this->flash('success', t('Items removed.'));
            $this->redirect('/dashboard/system/migration/export', 'view_batch', $batch->getId());
        }
        $this->render('/dashboard/system/migration/view_export_batch');
    }

    public function add_to_batch($id = null)
    {
        $this->requireAsset('migration/view-batch');
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch');
        $batch = $r->findOneById($id);
        if (is_object($batch)) {
            $exporters = \Core::make('migration/manager/exporters');
            if ($this->request->query->has('item_type') && $this->request->query->get('item_type')) {
                $selectedItemType = $exporters->driver($this->request->query->get('item_type'));
                if (is_object($selectedItemType)) {
                    $this->set('selectedItemType', $selectedItemType);
                }
            }
            $drivers = $exporters->getDrivers();
            usort($drivers, function ($a, $b) {
                return strcasecmp($a->getPluralDisplayName(), $b->getPluralDisplayName());
            });
            $this->set('drivers', $drivers);
            $this->set('batch', $batch);
            $this->set('request', $this->request);
            $this->set('pageTitle', t('Add To Batch'));
            $this->render('/dashboard/system/migration/add_to_export_batch');
        } else {
            $this->view();
        }
    }
}
