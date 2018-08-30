<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;

use Concrete\Core\Block\Block;
use Concrete\Core\Page\Type\Composer\FormLayoutSetControl;

defined('C5_EXECUTE') or die("Access Denied.");

class ComposerOutputContentItem extends Item
{
    protected $block;

    public function __construct(Block $block)
    {
        $c = $block->getBlockCollectionObject();
        $type = $c->getPageTypeObject();
        $template = $c->getPageTemplateObject();
        $control = $block->getController()->getComposerOutputControlObject();
        if (is_object($control)) {
            $control = FormLayoutSetControl::getByID($control->getPageTypeComposerFormLayoutSetControlID());
            $label = $control->getPageTypeComposerFormLayoutSetControlCustomLabel();
            if (!$label) {
                $cc = $control->getPageTypeComposerControlObject();
                $label = $cc->getPageTypeComposerControlDisplayName();
            }
            $components = array(
                $type->getPageTypeDisplayName(),
                $template->getPageTemplateDisplayName(),
                $block->getAreaHandle(),
                $label,
            );
            $this->block = $block;
            $this->setIdentifier($block->getBlockID());
            $this->setDisplayName(implode(' &gt; ', $components));
        }
    }

    public function getBlock()
    {
        return $this->block;
    }
}
