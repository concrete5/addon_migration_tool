<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;

defined('C5_EXECUTE') or die("Access Denied.");

interface ItemInterface
{
    public function getIdentifier();
    public function getDisplayName();
}
