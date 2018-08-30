<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AbstractBlock;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Block;

defined('C5_EXECUTE') or die("Access Denied.");

class BlockItem implements ItemInterface
{
    protected $block;

    public function __construct(AbstractBlock $block)
    {
        $this->block = $block;
    }

    public function getDisplayName()
    {
        if ($this->block->getType()) {
            return $this->block->getType();
        } elseif ($this->block->getDefaultsOutputIdentifier()) {
            return t('Defaults Output: %s', $this->block->getDefaultsOutputIdentifier());
        }
    }

    public function getIdentifier()
    {
        return $this->block->getType() ? $this->block->getType() : $this->block->getDefaultsOutputIdentifier();
    }
}
