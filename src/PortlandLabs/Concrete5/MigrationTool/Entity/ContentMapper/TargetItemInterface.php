<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper;

defined('C5_EXECUTE') or die("Access Denied.");

interface TargetItemInterface
{
    public function getItemName();
    public function getItemID();
    public function getItemType();
    public function isMapped();
    public function getSourceItemIdentifier();
    public function matches(TargetItemInterface $targetItem);
}
