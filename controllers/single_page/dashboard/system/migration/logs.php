<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration;

use Concrete\Package\MigrationTool\Page\Controller\DashboardPageController;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LogList;
use PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Log;

class Logs extends DashboardPageController
{

    public function view()
    {
        $list = new LogList($this->entityManager);
        $this->set('list', $list);
        $this->set('results', $list->getResults());
    }

    public function delete_log()
    {
        if (!$this->token->validate('delete_log')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $log = $this->entityManager->find(Log::class, $this->request->request->get('id'));
            if (is_object($log)) {
                $this->entityManager->remove($log);
                $this->entityManager->flush();
                $this->flash('success', t('Log removed successfully.'));
                $this->redirect('/dashboard/system/migration/logs');
            }
        }
        $this->view();
    }
    public function view_log($logID = null)
    {
        if ($logID) {
            $log = $this->entityManager->find(Log::class, $logID);
        }

        if (is_object($log)) {
            $this->set('log', $log);
            $this->set('entries', $log->getEntries());
            $this->set('messages', $log->getMessages());
            $this->set('pageTitle', t('View Log'));
            $this->render('/dashboard/system/migration/view_log');
        } else {
            return $this->redirect('/dashboard/system/migration/logs');
        }
    }

}
