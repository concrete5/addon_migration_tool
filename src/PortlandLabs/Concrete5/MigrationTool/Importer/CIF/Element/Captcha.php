<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\CaptchaObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class Captcha implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new CaptchaObjectCollection();
        if ($element->systemcaptcha->library) {
            foreach ($element->systemcaptcha->library as $node) {
                $library = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Captcha();
                $library->setHandle((string) $node['handle']);
                $library->setName((string) $node['name']);
                $library->setPackage((string) $node['package']);
                $library->setIsActivated((string) $node['activated']);

                $collection->getLibraries()->add($library);
                $library->setCollection($collection);
            }
        }

        return $collection;
    }
}
