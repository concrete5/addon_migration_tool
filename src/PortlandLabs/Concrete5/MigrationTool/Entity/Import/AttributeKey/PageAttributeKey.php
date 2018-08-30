<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportPageAttributeKeys")
 */
class PageAttributeKey extends AttributeKey
{
    public function getType()
    {
        return 'page';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }
}
