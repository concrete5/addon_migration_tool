<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element;

defined('C5_EXECUTE') or die("Access Denied.");

class StyleSet
{
    public function import(\SimpleXMLElement $node)
    {
        $o = new \PortlandLabs\Concrete5\MigrationTool\Entity\Import\StyleSet();
        $o->setBackgroundColor((string) $node->backgroundColor);
        $o->setBackgroundImage((string) $node->backgroundImage);
        $o->setBackgroundRepeat((string) $node->backgroundRepeat);
        $o->setBorderWidth((string) $node->borderWidth);
        $o->setBorderColor((string) $node->borderColor);
        $o->setBorderStyle((string) $node->borderStyle);
        $o->setBorderRadius((string) $node->borderRadius);
        $o->setBaseFontSize((string) $node->baseFontSize);
        $o->setAlignment((string) $node->alignment);
        $o->setTextColor((string) $node->textColor);
        $o->setLinkColor((string) $node->linkColor);
        $o->setPaddingTop((string) $node->paddingTop);
        $o->setPaddingBottom((string) $node->paddingBottom);
        $o->setPaddingLeft((string) $node->paddingLeft);
        $o->setPaddingRight((string) $node->paddingRight);
        $o->setMarginTop((string) $node->marginTop);
        $o->setMarginBottom((string) $node->marginBottom);
        $o->setMarginLeft((string) $node->marginLeft);
        $o->setMarginRight((string) $node->marginRight);
        $o->setRotate((string) $node->rotate);
        $o->setBoxShadowHorizontal((string) $node->boxShadowHorizontal);
        $o->setBoxShadowVertical((string) $node->boxShadowVertical);
        $o->setBoxShadowSpread((string) $node->boxShadowSpread);
        $o->setBoxShadowBlur((string) $node->boxShadowBlur);
        $o->setBoxShadowColor((string) $node->boxShadowColor);
        $o->setCustomClass((string) $node->customClass);
        $o->setHideOnExtraSmallDevice((bool) $node->hideOnExtraSmallDevice);
        $o->setHideOnSmallDevice((bool) $node->hideOnSmallDevice);
        $o->setHideOnMediumDevice((bool) $node->hideOnMediumDevice);
        $o->setHideOnLargeDevice((bool) $node->hideOnLargeDevice);

        return $o;
    }
}
