<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class BatchMessageCollectionFormatter extends MessageCollectionFormatter
{
    public function getAlertClass()
    {
        switch ($this->getSeverity()) {
            case Message::E_DANGER:
                return 'alert-danger';
                break;
            case Message::E_WARNING:
                return 'alert-warning';
                break;
            default:
                return 'alert-success';
                break;
        }
    }

    public function getCreateStatusMessage()
    {
        switch ($this->getSeverity()) {
            case Message::E_DANGER:
                return t('Significant errors detected. Some pages may be incomplete or the entire operation may have trouble completing. Consider mapping more content items.');
                break;
            case Message::E_WARNING:
                return t('Some potential problems detected. Consider mapping more content items.');
                break;
            default:
                return t('No errors detected.');
                break;
        }
    }
}
