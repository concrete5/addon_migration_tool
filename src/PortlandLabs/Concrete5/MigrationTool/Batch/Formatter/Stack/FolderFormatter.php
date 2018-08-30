<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\Stack;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StackFolder;

defined('C5_EXECUTE') or die("Access Denied.");

class FolderFormatter implements FormatterInterface
{
    protected $folder;

    public function __construct(StackFolder $folder)
    {
        $this->folder = $folder;
    }

    public function getIconClass()
    {
        return 'fa fa-folder';
    }
}
