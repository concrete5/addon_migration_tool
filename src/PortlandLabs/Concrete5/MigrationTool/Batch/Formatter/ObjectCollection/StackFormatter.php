<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class StackFormatter extends AbstractFormatter
{
    public function getPluralDisplayName()
    {
        return t('Stacks and Global Areas');
    }
}
