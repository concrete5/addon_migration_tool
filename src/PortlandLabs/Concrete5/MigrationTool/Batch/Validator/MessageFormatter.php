<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageFormatter
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    protected function getSeverity()
    {
        return $this->message->getSeverity();
    }

    public function getLevelClass()
    {
        switch ($this->getSeverity()) {
            case Message::E_DANGER:
                return 'danger';
                break;
            case Message::E_WARNING:
                return 'warning';
                break;
            default:
                return 'info';
                break;
        }
    }

    public function getIconClass()
    {
        switch ($this->getSeverity()) {
            case Message::E_DANGER:
                return 'text-danger fa fa-exclamation-triangle';
                break;
            case Message::E_WARNING:
                return 'text-warning fa fa-exclamation';
                break;
            default:
                return 'text-info fa fa-info-circle';
                break;
        }
    }

    public function output()
    {
        return sprintf('<span class="text-%s">%s</span>',
            $this->getLevelClass(),
            $this->message->getText()
        );
    }
}
