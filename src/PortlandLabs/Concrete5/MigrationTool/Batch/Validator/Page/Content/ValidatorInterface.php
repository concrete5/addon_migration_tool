<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;
use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\ItemInterface;

defined('C5_EXECUTE') or die("Access Denied.");

interface ValidatorInterface
{
    public function itemExists(ItemInterface $item, Batch $batch);
    public function addMissingItemMessage(ItemInterface $item, MessageCollection $messages);
}
