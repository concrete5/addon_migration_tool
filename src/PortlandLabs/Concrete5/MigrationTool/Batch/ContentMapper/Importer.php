<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper;

use Doctrine\ORM\EntityManagerInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\IgnoredTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\TargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper\UnmappedTargetItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BatchPresetTargetItem;

class Importer
{

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
            $cif = $this->wxr->xpath('/concrete5-migrator/mapping');
            if (!$cif) {
                $error->add(t('This does not appear to be a valid concrete5 mapping file.'));
            }
        }
    }

    public function getMappings($file)
    {
        $simplexml = simplexml_load_file($file);
        $presets = array();

        if ($simplexml->mapping->item) {
            foreach ($simplexml->mapping->item as $item) {
                $item_id = (string) $item->item_id;
                if ($item_id === '-1') {
                    $targetItem = new IgnoredTargetItem();
                } else if ($item_id === '0') {
                    $targetItem = new UnmappedTargetItem();
                } else {
                    $targetItem = new TargetItem();
                }
                $targetItem->setSourceItemIdentifier((string) $item->source_item_identifier);
                $targetItem->setItemId($item_id);
                $targetItem->setItemType((string) $item->item_type);

                $preset = new BatchPresetTargetItem();
                $preset->setTargetItem($targetItem);
                $presets[] = $preset;
            }
        }

        return $presets;
    }

}
