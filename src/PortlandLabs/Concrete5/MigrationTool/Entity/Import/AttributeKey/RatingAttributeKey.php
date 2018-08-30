<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKey\BlankFormatter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationImportRatingAttributeKeys")
 */
class RatingAttributeKey extends AttributeKey
{
    public function getType()
    {
        return 'rating';
    }

    public function getFormatter()
    {
        return new BlankFormatter($this);
    }
}
