<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Queue;

use Concrete\Core\Foundation\Queue\Queue as CoreQueue;

abstract class Queue
{

    protected $queue;

    public function __construct($identifier)
    {
        $this->queue = CoreQueue::get($identifier);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->queue, $name], $arguments);
    }

    /**
     * @return \ZendQueue\Queue
     */
    public function getQueue()
    {
        return $this->queue;
    }


}