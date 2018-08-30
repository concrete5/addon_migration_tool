<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control;

class TextFormatter extends AbstractFormatter
{

    public function getControlLabel()
    {
        $label = $this->control->getCustomLabel();
        if ($label) {
            return $label;
        }
        return $this->control->getHeadline();
    }

    public function getIconClass()
    {
        return 'fa fa-quote-right';
    }

    public function getControlTypeText()
    {
        return t('Text');
    }


}
