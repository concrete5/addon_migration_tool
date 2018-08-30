<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute;

use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Attribute;

defined('C5_EXECUTE') or die("Access Denied.");

interface ValidatableAttributesInterface
{

    function getAttributeValidatorDriver();

}
