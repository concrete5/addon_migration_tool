<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use Concrete\Core\Foundation\Processor\TargetInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface ValidatorTargetInterface extends TargetInterface
{
    public function addMessage(Message $message);
    public function getMessages();
}
