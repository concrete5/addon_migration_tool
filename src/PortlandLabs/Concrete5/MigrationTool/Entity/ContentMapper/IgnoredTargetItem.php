<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\ContentMapper;
use Doctrine\ORM\Mapping as ORM;

use PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\MapperInterface;

defined('C5_EXECUTE') or die("Access Denied.");

/**
 * @ORM\Entity
 */
class IgnoredTargetItem extends TargetItem
{
    public function __construct(MapperInterface $mapper = null)
    {
        parent::__construct($mapper);
        $this->setItemId(-1);
        $this->setItemName(t('Ignored'));
    }

    public function isMapped()
    {
        return false;
    }
}
