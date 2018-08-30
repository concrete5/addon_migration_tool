<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BannedWordObjectCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\ElementParserInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class BannedWord implements ElementParserInterface
{
    public function getObjectCollection(\SimpleXMLElement $element, Batch $batch)
    {
        $collection = new BannedWordObjectCollection();
        if ($element->banned_words->banned_word) {
            foreach ($element->banned_words->banned_word as $node) {
                $word = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\BannedWord();
                $word->setWord((string) $node);
                $collection->getWords()->add($word);
                $word->setCollection($collection);
            }
        }

        return $collection;
    }
}
