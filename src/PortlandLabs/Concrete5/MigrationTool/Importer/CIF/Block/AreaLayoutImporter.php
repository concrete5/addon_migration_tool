<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Block;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayoutColumnBlock;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\CustomAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\PresetAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayout;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\ThemeGridAreaLayoutColumn;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\BlockValue\AreaLayoutBlockValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\StyleSet;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AreaLayout\AreaLayout;

defined('C5_EXECUTE') or die("Access Denied.");

class AreaLayoutImporter extends AbstractImporter
{
    /**
     * @param $type
     * @param \stdClass $node
     *
     * @return AreaLayout
     */
    public function createLayoutObject($type, \SimpleXMLElement $node)
    {
        switch ($type) {
            case 'custom':
                $layout = new CustomAreaLayout();
                $layout->setSpacing(intval($node['spacing']));
                $customWidths = intval($node['custom-widths']);
                if ($customWidths == 1) {
                    $layout->setHasCustomWidths(true);
                }
                break;
            case 'theme-grid':
                $layout = new ThemeGridAreaLayout();
                $layout->setMaxColumns(intval($node['columns']));
                break;
            default: // preset
                $layout = new PresetAreaLayout();
                $layout->setPreset((string) $node['preset']);
                break;
        }

        return $layout;
    }

    protected function createColumnObject($type, \SimpleXMLElement $node)
    {
        switch ($type) {
            case 'custom':
                $column = new CustomAreaLayoutColumn();
                $column->setWidth(intval($node['width']));
                break;
            case 'theme-grid':
                $column = new ThemeGridAreaLayoutColumn();
                $column->setSpan(intval($node['span']));
                $column->setOffset(intval($node['offset']));
                break;
            default: // preset
                $column = new PresetAreaLayoutColumn();
                break;
        }

        return $column;
    }

    public function parse(\SimpleXMLElement $node)
    {
        $blockImporter = \Core::make('migration/manager/import/cif_block');
        $styleSetImporter = new StyleSet();

        $value = new AreaLayoutBlockValue();
        $type = (string) $node->arealayout['type'];
        $layout = $this->createLayoutObject($type, $node->arealayout);
        foreach ($node->arealayout->columns->column as $columnNode) {
            $column = $this->createColumnObject($type, $columnNode);
            $column->setAreaLayout($layout);
            $i = 0;
            foreach ($columnNode->block as $blockNode) {
                if ($blockNode['type']) {
                    $block = new AreaLayoutColumnBlock();
                    $block->setColumn($column);
                    $block->setType((string) $blockNode['type']);
                    $block->setName((string) $blockNode['name']);
                    $bFilename = (string) $blockNode['custom-template'];
                    if ($bFilename) {
                        $block->setCustomTemplate($bFilename);
                    }
                    $block->setDefaultsOutputIdentifier((string) $node['mc-block-id']);
                    if (isset($blockNode->style)) {
                        $styleSet = $styleSetImporter->import($blockNode->style);
                        $block->setStyleSet($styleSet);
                    }
                    $blockValue = $blockImporter->driver((string) $blockNode['type'])->parse($blockNode);
                    $block->setBlockValue($blockValue);
                    $block->setPosition($i);
                    $column->getBlocks()->add($block);
                    ++$i;
                }
            }
            $layout->getColumns()->add($column);
        }
        $value->setAreaLayout($layout);

        return $value;
    }
}
