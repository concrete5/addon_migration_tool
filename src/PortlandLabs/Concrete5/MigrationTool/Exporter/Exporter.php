<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter;

use Concrete\Core\File\File;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Exporter
{
    protected $batch;
    protected $built = false;
    protected $element;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    protected function build()
    {
        $this->element = new \SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><concrete5-cif></concrete5-cif>");
        $this->element->addAttribute('version', '1.0');
        foreach ($this->batch->getObjectCollections() as $collection) {
            $type = $collection->getItemTypeObject();
            $type->exportCollection($collection, $this->element);
        }
    }

    public function getElement()
    {
        if (!$this->built) {
            $this->build();
        }

        return $this->element;
    }

    /**
     * Loops through all pages and returns files referenced.
     */
    public function getReferencedFiles()
    {
        $regExp = '/\{ccm:export:file:(.*?)\}|\{ccm:export:image:(.*?)\}|\<concrete-picture\s[^>]*?file\s*=\s*[\'"]([^\'"]*?)[\'"][^>]*?>/i';
        $items = array();
        if (preg_match_all(
            $regExp,
            $this->getElement()->asXML(),
            $matches
        )
        ) {
            if (count($matches)) {
                for ($i = 1; $i < count($matches); ++$i) {
                    $results = $matches[$i];
                    foreach ($results as $reference) {
                        if ($reference) {
                            $items[] = $reference;
                        }
                    }
                }
            }
        }
        $files = array();
        $db = \Database::connection();
        foreach ($items as $item) {
            $fID = null;
            if (strpos($item, ':') > -1) {
                list($fvPrefix, $fvFilename) = explode(':', $item);
                $fID = $db->GetOne('select fID from FileVersions where fvPrefix = ? and fvFilename = ?', array($fvPrefix, $fvFilename));
            }
            if (!$fID) {
                $fID = $db->GetOne('select fID from FileVersions where fvFilename = ?', array($item));
            }
            if ($fID) {
                $f = File::getByID($fID);
                if (is_object($f) && !$f->isError() && !in_array($f, $files)) {
                    $files[] = $f;
                }
            }
        }

        return $files;
    }

}
