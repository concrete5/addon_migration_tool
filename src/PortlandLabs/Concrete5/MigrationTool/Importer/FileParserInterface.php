<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

interface FileParserInterface
{
    public function getDriver();
    public function getName();
    public function validateUploadedFile(array $file, &$error);

    /**
     * @param $file
     */
    public function addContentObjectCollectionsToBatch($file, Batch $batch);
}
