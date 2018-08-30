<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Attribute;

use Concrete\Core\Entity\Attribute\Value\Value\AddressValue;
use Concrete\Core\Attribute\Key\CollectionKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AttributeValue;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeValue\AddressAttributeValue;
use Concrete\Core\Page\Page;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class AddressPublisher implements PublisherInterface
{
    /**
     * @param CollectionKey $ak
     * @param Page $page
     * @param AddressAttributeValue $address
     */
    public function publish(Batch $batch, $ak, $subject, AttributeValue $address)
    {
        $value = new AddressValue();
        $value->address1 = $address->getAddress1();
        $value->address2 = $address->getAddress2();
        $value->address3 = $address->getAddress3();
        $value->city = $address->getCity();
        $value->country = $address->getCountry();
        $value->state_province = $address->getStateProvince();
        $value->postal_code = $address->getPostalCode();
        $subject->setAttribute($ak->getAttributeKeyHandle(), $value);
    }
}
