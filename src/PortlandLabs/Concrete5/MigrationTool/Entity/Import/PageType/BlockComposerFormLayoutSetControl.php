<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType\BlockComposerFormLayoutSetControlValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BlockComposerFormLayoutSetControl extends ComposerFormLayoutSetControl
{
    public function getHandle()
    {
        return 'block';
    }

    public function getRecordValidator(ValidatorInterface $batch)
    {
        return new BlockComposerFormLayoutSetControlValidator($batch);
    }
}
