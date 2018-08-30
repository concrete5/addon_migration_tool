<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

use Concrete\Core\Foundation\Processor\Processor;
use Concrete\Core\Foundation\Processor\TaskInterface;

defined('C5_EXECUTE') or die("Access Denied.");

abstract class ValidateProcessor extends AbstractValidator
{
    protected $tasks = array();
    protected $processor;

    /**
     * @param $mixed
     *
     * @return ValidatorTargetInterface
     */
    abstract public function getTarget($mixed);

    public function registerTask(TaskInterface $task)
    {
        $this->tasks[] = $task;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getProcessor(ValidatorTargetInterface $target)
    {
        return new Processor($target);
    }

    /**
     * @param mixed $processor
     */
    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

    public function validate($mixed)
    {
        $target = $this->getTarget($mixed);
        $processor = $this->getProcessor($target);
        foreach ($this->tasks as $task) {
            $processor->registerTask($task);
        }
        $processor->process();

        return $target->getMessages();
    }
}
