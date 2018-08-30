<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control;

class AttributeKeyFormatter extends AbstractFormatter
{

    public function getControlLabel()
    {
        $label = $this->control->getCustomLabel();
        if ($label) {
            return $label;
        }
        return $this->control->getAttributeKey();
    }

    public function getIconClass()
    {
        return 'fa fa-cog';
    }

    public function getControlTypeText()
    {
        return t('Attribute Key');
    }


}
