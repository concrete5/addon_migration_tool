<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration\Import\Settings;

use Concrete\Core\File\Importer;
use Concrete\Core\File\Set\Set;
use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Package\MigrationTool\Controller\Element\Dashboard\Batches\Settings\Header;
use Concrete\Package\MigrationTool\Page\Controller\DashboardMigrationSettingsController;
use Concrete\Package\MigrationTool\Page\Controller\DashboardPageController;
use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchService;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Exporter;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\PresetManager;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Page\TreePageJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Site\TreeSiteJsonFormatter;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\PublisherRoutineProcessor;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Target;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\TargetItemProcessor;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\Task\NormalizePagePathsTask;
use PortlandLabs\Concrete5\MigrationTool\Batch\Processor\UntransformedItemProcessor;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Importer\FileParser as Parser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class Basics extends DashboardMigrationSettingsController
{

    public function view($id = null)
    {
        $batch = $this->getBatch($id);
        if (is_object($batch)) {
            $this->set('headerMenu', new Header($batch));
            $presetManager = new PresetManager($this->entityManager);
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Settings'));
            $this->set('presetMappings', $presetManager->getPresets($batch));
            $this->set('sites', $this->app->make('site')->getList());
        } else {
            $this->redirect('/dashboard/system/migration');
        }
    }

    public function save_batch_settings()
    {
        if (!$this->token->validate('save_batch_settings')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $batch = $this->getBatch($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        if ($_FILES['mappingFile']['tmp_name']) {
            $importer = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Importer();
            $importer->validateUploadedFile($_FILES['mappingFile'], $this->error);
        }

        if (!$this->error->has()) {

            if ($this->request->request->has('download_mappings') && $this->request->request->get('download_mappings')) {
                // download the mapping files

                $exporter = new Exporter($batch);

                $response = new Response($exporter->getElement()->asXML(), Response::HTTP_OK, array(
                        'content-type' => 'text/xml'
                    )
                );

                $disposition = $response->headers->makeDisposition(
                    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                    'mappings.xml'
                );

                $response->headers->set('Content-Disposition', $disposition);

                return $response;

            } else if ($this->request->request->has('delete_mapping_presets') && $this->request->request->get('delete_mapping_presets')) {


                $presetManager = new PresetManager($this->entityManager);
                $presetManager->clearPresets($batch);
                $this->flash('success', t('Batch presets removed successfully.'));
                $this->redirect('/dashboard/system/migration/import/settings/basics', $batch->getId());

            } else {
                $batch->setName($this->request->request->get('name'));
                $site = null;
                if ($this->request->request->has('siteID')) {
                    $site = $this->app->make('site')->getByID($this->request->request->get('siteID'));
                }
                if (!is_object($site)) {
                    $site = $this->app->make('site')->getDefault();
                }
                $batch->setSite($site);
                if ($_FILES['mappingFile']['tmp_name']) {
                    $importer = new \PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Importer();
                    $mappings = $importer->getMappings($_FILES['mappingFile']['tmp_name']);
                    $presetManager = new PresetManager($this->entityManager);
                    $presetManager->clearPresets($batch);
                    $presetManager->savePresets($batch, $mappings);
                    $presetManager->clearBatchMappings($batch);
                    $this->flash('success', t('Batch updated successfully. Since you uploaded presets, existing mappings were removed. Please rescan the batch.'));
                } else {
                    $this->flash('success', t('Batch updated successfully.'));
                }
                $this->entityManager->persist($batch);
                $this->entityManager->flush();
                $this->redirect('/dashboard/system/migration/import', 'view_batch', $batch->getId());
            }
        }
        $this->view($this->request->request->get('id'));
    }

}
