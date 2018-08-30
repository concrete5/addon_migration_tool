<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control;

interface FormatterInterface
{
    function getControlLabel();
    function getControlTypeText();
    function getIconClass();
}
