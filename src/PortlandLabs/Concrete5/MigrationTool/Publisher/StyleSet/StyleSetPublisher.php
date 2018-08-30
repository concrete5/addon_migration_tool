<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\StyleSet;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StyleSet;
use Concrete\Core\Entity\StyleCustomizer\Inline\StyleSet as CoreStyleSet;
class StyleSetPublisher
{
    protected $styleSet;

    public function __construct(StyleSet $styleSet)
    {
        $this->styleSet = $styleSet;
    }

    /**
     * @return CoreStyleSet
     */
    public function publish()
    {
        $o = new CoreStyleSet();
        $o->setBackgroundColor($this->styleSet->getBackgroundColor());
        $filename = $this->styleSet->getBackgroundImage();
        if ($filename) {
            $inspector = \Core::make('import/value_inspector');
            $result = $inspector->inspect($filename);
            $fID = $result->getReplacedValue();
            if ($fID) {
                $o->setBackgroundImageFileID($fID);
            }
        }
        $o->setBackgroundRepeat($this->styleSet->getBackgroundRepeat());
        $o->setBorderWidth($this->styleSet->getBorderWidth());
        $o->setBorderColor($this->styleSet->getBorderColor());
        $o->setBorderStyle($this->styleSet->getBorderStyle());
        $o->setBorderRadius($this->styleSet->getBorderRadius());
        $o->setBaseFontSize($this->styleSet->getBaseFontSize());
        $o->setAlignment($this->styleSet->getAlignment());
        $o->setTextColor($this->styleSet->getTextColor());
        $o->setLinkColor($this->styleSet->getLinkColor());
        $o->setPaddingTop($this->styleSet->getPaddingTop());
        $o->setPaddingBottom($this->styleSet->getPaddingBottom());
        $o->setPaddingLeft($this->styleSet->getPaddingLeft());
        $o->setPaddingRight($this->styleSet->getPaddingRight());
        $o->setMarginTop($this->styleSet->getMarginTop());
        $o->setMarginBottom($this->styleSet->getMarginBottom());
        $o->setMarginLeft($this->styleSet->getMarginLeft());
        $o->setMarginRight($this->styleSet->getMarginRight());
        $o->setRotate($this->styleSet->getRotate());
        $o->setBoxShadowHorizontal($this->styleSet->getBoxShadowHorizontal());
        $o->setBoxShadowVertical($this->styleSet->getBoxShadowVertical());
        $o->setBoxShadowSpread($this->styleSet->getBoxShadowSpread());
        $o->setBoxShadowBlur($this->styleSet->getBoxShadowBlur());
        $o->setBoxShadowColor($this->styleSet->getBoxShadowColor());
        $o->setCustomClass($this->styleSet->getCustomClass());
        $o->setHideOnExtraSmallDevice($this->styleSet->getHideOnExtraSmallDevice());
        $o->setHideOnSmallDevice($this->styleSet->getHideOnSmallDevice());
        $o->setHideOnMediumDevice($this->styleSet->getHideOnMediumDevice());
        $o->setHideOnLargeDevice($this->styleSet->getHideOnLargeDevice());
        $o->save();

        return $o;
    }
}
