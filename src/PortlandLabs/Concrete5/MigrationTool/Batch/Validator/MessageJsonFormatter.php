<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class MessageJsonFormatter implements \JsonSerializable
{
    protected $message;
    protected $formatter;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->formatter = new MessageFormatter($message);
    }

    public function jsonSerialize()
    {
        return array(
            'severity' => $this->message->getSeverity(),
            'text' => $this->message->getText(),
            'levelClass' => $this->formatter->getLevelClass(),
            'iconClass' => $this->formatter->getIconClass(),
        );
    }
}
