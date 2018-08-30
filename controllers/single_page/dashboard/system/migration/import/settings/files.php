<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration\Import\Settings;

use Concrete\Package\MigrationTool\Controller\Element\Dashboard\Batches\Settings\Header;
use Concrete\Package\MigrationTool\Page\Controller\DashboardMigrationSettingsController;

class Files extends DashboardMigrationSettingsController
{

    public function view($id = null)
    {
        $batch = $this->getBatch($id);
        if (is_object($batch)) {
            $this->set('headerMenu', new Header($batch));
            $this->set('batch', $batch);
            $this->set('pageTitle', t('Files Settings'));
            $this->set('folderID', $batch->getFileFolderID());
        } else {
            $this->redirect('/dashboard/system/migration');
        }
    }

    public function save_files_settings()
    {
        if (!$this->token->validate('save_files_settings')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $batch = $this->getBatch($this->request->request->get('id'));
        if (!is_object($batch)) {
            $this->error->add(t('Invalid batch.'));
        }

        if (!$this->error->has()) {

            $batch->setFileFolderID($this->request->request->get('folderID'));
            $this->entityManager->persist($batch);
            $this->entityManager->flush();
            $this->flash('success', t("Files settings updated."));
            $this->redirect('/dashboard/system/migration/import', 'view_batch', $batch->getId());

        }

        $this->view($this->request->request->get('id'));
    }

}