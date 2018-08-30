<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Publisher\StyleSet\StyleSetPublisher;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportStyleSets")
 */
class StyleSet
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $customClass;

    /**
     * @ORM\Column(type="string")
     */
    protected $backgroundColor;

    /**
     * @ORM\Column(type="string")
     */
    protected $backgroundImage;

    /**
     * @ORM\Column(type="string")
     */
    protected $backgroundRepeat = 'no-repeat';

    /**
     * @ORM\Column(type="string")
     */
    protected $borderColor;

    /**
     * @ORM\Column(type="string")
     */
    protected $borderStyle;

    /**
     * @ORM\Column(type="string")
     */
    protected $borderWidth;

    /**
     * @ORM\Column(type="string")
     */
    protected $borderRadius;

    /**
     * @ORM\Column(type="string")
     */
    protected $baseFontSize;

    /**
     * @ORM\Column(type="string")
     */
    protected $alignment;

    /**
     * @ORM\Column(type="string")
     */
    protected $textColor;

    /**
     * @ORM\Column(type="string")
     */
    protected $linkColor;

    /**
     * @ORM\Column(type="string")
     */
    protected $marginTop;

    /**
     * @ORM\Column(type="string")
     */
    protected $marginBottom;

    /**
     * @ORM\Column(type="string")
     */
    protected $marginLeft;

    /**
     * @ORM\Column(type="string")
     */
    protected $marginRight;

    /**
     * @ORM\Column(type="string")
     */
    protected $paddingTop;

    /**
     * @ORM\Column(type="string")
     */
    protected $paddingBottom;

    /**
     * @ORM\Column(type="string")
     */
    protected $paddingLeft;

    /**
     * @ORM\Column(type="string")
     */
    protected $paddingRight;

    /**
     * @ORM\Column(type="string")
     */
    protected $rotate;

    /**
     * @ORM\Column(type="string")
     */
    protected $boxShadowHorizontal;

    /**
     * @ORM\Column(type="string")
     */
    protected $boxShadowVertical;

    /**
     * @ORM\Column(type="string")
     */
    protected $boxShadowBlur;

    /**
     * @ORM\Column(type="string")
     */
    protected $boxShadowSpread;

    /**
     * @ORM\Column(type="string")
     */
    protected $boxShadowColor;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hideOnExtraSmallDevice = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hideOnSmallDevice = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hideOnMediumDevice = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $hideOnLargeDevice = false;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCustomClass()
    {
        return $this->customClass;
    }

    /**
     * @param mixed $customClass
     */
    public function setCustomClass($customClass)
    {
        $this->customClass = $customClass;
    }

    /**
     * @return mixed
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param mixed $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return mixed
     */
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * @param mixed $backgroundImage
     */
    public function setBackgroundImage($backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;
    }

    /**
     * @return mixed
     */
    public function getBackgroundRepeat()
    {
        return $this->backgroundRepeat;
    }

    /**
     * @param mixed $backgroundRepeat
     */
    public function setBackgroundRepeat($backgroundRepeat)
    {
        $this->backgroundRepeat = $backgroundRepeat;
    }

    /**
     * @return mixed
     */
    public function getBorderColor()
    {
        return $this->borderColor;
    }

    /**
     * @param mixed $borderColor
     */
    public function setBorderColor($borderColor)
    {
        $this->borderColor = $borderColor;
    }

    /**
     * @return mixed
     */
    public function getBorderStyle()
    {
        return $this->borderStyle;
    }

    /**
     * @param mixed $borderStyle
     */
    public function setBorderStyle($borderStyle)
    {
        $this->borderStyle = $borderStyle;
    }

    /**
     * @return mixed
     */
    public function getBorderWidth()
    {
        return $this->borderWidth;
    }

    /**
     * @param mixed $borderWidth
     */
    public function setBorderWidth($borderWidth)
    {
        $this->borderWidth = $borderWidth;
    }

    /**
     * @return mixed
     */
    public function getBorderRadius()
    {
        return $this->borderRadius;
    }

    /**
     * @param mixed $borderRadius
     */
    public function setBorderRadius($borderRadius)
    {
        $this->borderRadius = $borderRadius;
    }

    /**
     * @return mixed
     */
    public function getBaseFontSize()
    {
        return $this->baseFontSize;
    }

    /**
     * @param mixed $baseFontSize
     */
    public function setBaseFontSize($baseFontSize)
    {
        $this->baseFontSize = $baseFontSize;
    }

    /**
     * @return mixed
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * @param mixed $alignment
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;
    }

    /**
     * @return mixed
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * @param mixed $textColor
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;
    }

    /**
     * @return mixed
     */
    public function getLinkColor()
    {
        return $this->linkColor;
    }

    /**
     * @param mixed $linkColor
     */
    public function setLinkColor($linkColor)
    {
        $this->linkColor = $linkColor;
    }

    /**
     * @return mixed
     */
    public function getMarginTop()
    {
        return $this->marginTop;
    }

    /**
     * @param mixed $marginTop
     */
    public function setMarginTop($marginTop)
    {
        $this->marginTop = $marginTop;
    }

    /**
     * @return mixed
     */
    public function getMarginBottom()
    {
        return $this->marginBottom;
    }

    /**
     * @param mixed $marginBottom
     */
    public function setMarginBottom($marginBottom)
    {
        $this->marginBottom = $marginBottom;
    }

    /**
     * @return mixed
     */
    public function getMarginLeft()
    {
        return $this->marginLeft;
    }

    /**
     * @param mixed $marginLeft
     */
    public function setMarginLeft($marginLeft)
    {
        $this->marginLeft = $marginLeft;
    }

    /**
     * @return mixed
     */
    public function getMarginRight()
    {
        return $this->marginRight;
    }

    /**
     * @param mixed $marginRight
     */
    public function setMarginRight($marginRight)
    {
        $this->marginRight = $marginRight;
    }

    /**
     * @return mixed
     */
    public function getPaddingTop()
    {
        return $this->paddingTop;
    }

    /**
     * @param mixed $paddingTop
     */
    public function setPaddingTop($paddingTop)
    {
        $this->paddingTop = $paddingTop;
    }

    /**
     * @return mixed
     */
    public function getPaddingBottom()
    {
        return $this->paddingBottom;
    }

    /**
     * @param mixed $paddingBottom
     */
    public function setPaddingBottom($paddingBottom)
    {
        $this->paddingBottom = $paddingBottom;
    }

    /**
     * @return mixed
     */
    public function getPaddingLeft()
    {
        return $this->paddingLeft;
    }

    /**
     * @param mixed $paddingLeft
     */
    public function setPaddingLeft($paddingLeft)
    {
        $this->paddingLeft = $paddingLeft;
    }

    /**
     * @return mixed
     */
    public function getPaddingRight()
    {
        return $this->paddingRight;
    }

    /**
     * @param mixed $paddingRight
     */
    public function setPaddingRight($paddingRight)
    {
        $this->paddingRight = $paddingRight;
    }

    /**
     * @return mixed
     */
    public function getRotate()
    {
        return $this->rotate;
    }

    /**
     * @param mixed $rotate
     */
    public function setRotate($rotate)
    {
        $this->rotate = $rotate;
    }

    /**
     * @return mixed
     */
    public function getBoxShadowHorizontal()
    {
        return $this->boxShadowHorizontal;
    }

    /**
     * @param mixed $boxShadowHorizontal
     */
    public function setBoxShadowHorizontal($boxShadowHorizontal)
    {
        $this->boxShadowHorizontal = $boxShadowHorizontal;
    }

    /**
     * @return mixed
     */
    public function getBoxShadowVertical()
    {
        return $this->boxShadowVertical;
    }

    /**
     * @param mixed $boxShadowVertical
     */
    public function setBoxShadowVertical($boxShadowVertical)
    {
        $this->boxShadowVertical = $boxShadowVertical;
    }

    /**
     * @return mixed
     */
    public function getBoxShadowBlur()
    {
        return $this->boxShadowBlur;
    }

    /**
     * @param mixed $boxShadowBlur
     */
    public function setBoxShadowBlur($boxShadowBlur)
    {
        $this->boxShadowBlur = $boxShadowBlur;
    }

    /**
     * @return mixed
     */
    public function getBoxShadowSpread()
    {
        return $this->boxShadowSpread;
    }

    /**
     * @param mixed $boxShadowSpread
     */
    public function setBoxShadowSpread($boxShadowSpread)
    {
        $this->boxShadowSpread = $boxShadowSpread;
    }

    /**
     * @return mixed
     */
    public function getBoxShadowColor()
    {
        return $this->boxShadowColor;
    }

    /**
     * @param mixed $boxShadowColor
     */
    public function setBoxShadowColor($boxShadowColor)
    {
        $this->boxShadowColor = $boxShadowColor;
    }

    /**
     * @return mixed
     */
    public function getHideOnExtraSmallDevice()
    {
        return $this->hideOnExtraSmallDevice;
    }

    /**
     * @param mixed $hideOnExtraSmallDevice
     */
    public function setHideOnExtraSmallDevice($hideOnExtraSmallDevice)
    {
        $this->hideOnExtraSmallDevice = $hideOnExtraSmallDevice;
    }

    /**
     * @return mixed
     */
    public function getHideOnSmallDevice()
    {
        return $this->hideOnSmallDevice;
    }

    /**
     * @param mixed $hideOnSmallDevice
     */
    public function setHideOnSmallDevice($hideOnSmallDevice)
    {
        $this->hideOnSmallDevice = $hideOnSmallDevice;
    }

    /**
     * @return mixed
     */
    public function getHideOnMediumDevice()
    {
        return $this->hideOnMediumDevice;
    }

    /**
     * @param mixed $hideOnMediumDevice
     */
    public function setHideOnMediumDevice($hideOnMediumDevice)
    {
        $this->hideOnMediumDevice = $hideOnMediumDevice;
    }

    /**
     * @return mixed
     */
    public function getHideOnLargeDevice()
    {
        return $this->hideOnLargeDevice;
    }

    /**
     * @param mixed $hideOnLargeDevice
     */
    public function setHideOnLargeDevice($hideOnLargeDevice)
    {
        $this->hideOnLargeDevice = $hideOnLargeDevice;
    }

    public function getPublisher()
    {
        return new StyleSetPublisher($this);
    }
}
