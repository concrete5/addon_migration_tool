<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\FileParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CIFParser implements FileParserInterface
{
    public function getDriver()
    {
        return 'concrete5';
    }

    public function getName()
    {
        return t('concrete5 XML Export');
    }

    public function validateUploadedFile(array $file, &$error)
    {
        if ($file['type'] != 'text/xml') {
            $error->add(t('File does not appear to be an XML file.'));
        }

        libxml_use_internal_errors(true);
        $this->wxr = simplexml_load_file($file['tmp_name']);
        $XMLErrors = libxml_get_errors();

        foreach ($XMLErrors as $XMLError) {
            $error->add(t('XML format error. ' . $XMLError->message));
        }

        if ($this->wxr) {
            $this->namespaces = $this->wxr->getDocNamespaces();
            $cif = $this->wxr->xpath('/concrete5-cif');
            if (!$cif) {
                $error->add(t('This does not appear to be a valid concrete5 CIF file.'));
            }
        }
    }

    public function addContentObjectCollectionsToBatch($file, Batch $batch)
    {
        $manager = \Core::make('migration/manager/importer/cif');
        $simplexml = simplexml_load_file($file);
        foreach ($manager->getRoutines() as $driver) {
            $collection = $driver->getObjectCollection($simplexml, $batch);
            if ($collection) {
                if (!($collection instanceof ObjectCollection)) {
                    throw new \RuntimeException(t('Driver %s getObjectCollection did not return an object of the ObjectCollection type', get_class($driver)));
                } else {
                    // does this already exist ?
                    $existingCollection = $batch->getObjectCollection($collection->getType());
                    if (is_object($existingCollection)) {
                        foreach($collection->getRecords() as $record) {
                            $record->setCollection($existingCollection);
                            $existingCollection->getRecords()->add($record);
                        }
                    } else {
                        $batch->getObjectCollections()->add($collection);
                    }
                }
            }
        }
    }
}
