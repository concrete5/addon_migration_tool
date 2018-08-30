<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ValidatableAttributesInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Entry\PublishCompleteEntryFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PageValidator;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\SiteValidator;

/**
 * @ORM\Entity
 */
class PublishCompleteEntry extends Entry
{

    public function getEntryFormatter()
    {
        return new PublishCompleteEntryFormatter($this);
    }

}
