<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control;

class AssociationFormatter extends AbstractFormatter
{

    public function getControlLabel()
    {
        $label = $this->control->getCustomLabel();
        if ($label) {
            return $label;
        }
        return $this->control->getAssociation();
    }

    public function getIconClass()
    {
        return 'fa fa-sitemap';
    }

    public function getControlTypeText()
    {
        return t('Association');
    }


}
