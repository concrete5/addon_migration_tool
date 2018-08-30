<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatorTarget implements ValidatorTargetInterface
{
    protected $messages;
    protected $batch;

    public function __construct(ValidatorInterface $batch)
    {
        $this->batch = $batch;
        $this->messages = new MessageCollection();
    }

    /**
     * @return Batch
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * @param Batch $batch
     */
    public function setBatch($batch)
    {
        $this->batch = $batch;
    }

    public function getItems()
    {
        return array($this->batch);
    }

    public function addMessage(Message $message)
    {
        $this->messages->add($message);
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
