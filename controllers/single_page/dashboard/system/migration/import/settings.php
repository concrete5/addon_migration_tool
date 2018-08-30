<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System\Migration\Import;

use Concrete\Core\Page\Controller\DashboardPageController;

class Settings extends DashboardPageController
{
    public function view()
    {
        $this->redirect('/dashboard/system/migration/import');
    }
}
