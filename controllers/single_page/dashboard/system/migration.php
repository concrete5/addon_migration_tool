<?php
namespace Concrete\Package\MigrationTool\Controller\SinglePage\Dashboard\System;

use Concrete\Core\Page\Controller\DashboardPageController;

class Migration extends DashboardPageController
{
    public function view()
    {
        $this->redirect('/dashboard/system/migration/import');
    }
}
