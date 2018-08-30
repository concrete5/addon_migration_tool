<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Validator;

use Concrete\Core\Job\Job;

class JobValidator extends AbstractValidator
{
    public function skipItem()
    {
        $job = Job::getByHandle($this->object->getHandle());

        return is_object($job);
    }
}
