<?php
namespace Concrete\Package\MigrationTool\Page\Controller;

use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

class DashboardPageController extends \Concrete\Core\Page\Controller\DashboardPageController
{

    public function on_start()
    {
        set_time_limit(0);
        parent::on_start();
    }

    /**
     * @param $id
     * @return Batch
     */
    protected function getBatch($id)
    {
        $r = $this->entityManager->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch');
        $batch = $r->findOneById($id);
        return $batch;
    }
}
