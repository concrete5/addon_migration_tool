<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

class BlankFormatter extends AbstractFormatter
{
    public function getBatchTreeNodeJsonObject()
    {
        return false;
    }
}
