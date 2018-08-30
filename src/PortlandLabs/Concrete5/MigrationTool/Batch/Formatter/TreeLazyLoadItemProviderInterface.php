<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter;

defined('C5_EXECUTE') or die("Access Denied.");

interface TreeLazyLoadItemProviderInterface
{
    public function getItemFormatterByID($id);
}
