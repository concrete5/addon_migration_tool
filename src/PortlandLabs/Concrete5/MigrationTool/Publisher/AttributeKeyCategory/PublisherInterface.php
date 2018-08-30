<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory;

use Concrete\Core\Package\Package;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\AttributeKey;

defined('C5_EXECUTE') or die("Access Denied.");

interface PublisherInterface
{
    /**
     * @param AttributeKey $ak
     *
     * @return \Concrete\Core\Attribute\Key\Key
     */
    public function publish(AttributeKey $ak, Package $pkg = null);
}
