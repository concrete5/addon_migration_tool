<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ObjectCollection;

defined('C5_EXECUTE') or die("Access Denied.");

class ThumbnailTypeFormatter extends AbstractFormatter
{
    public function getPluralDisplayName()
    {
        return t('Thumbnail Types');
    }
}
