<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

interface ItemValidatorInterface
{
    /**
     * @param $mixed
     *
     * @return MessageCollection
     */
    public function validate($mixed);
}
