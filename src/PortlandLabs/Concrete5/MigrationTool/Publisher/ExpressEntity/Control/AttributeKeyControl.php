<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\ExpressEntity\Control;

use Concrete\Core\Application\Application;
use Concrete\Core\Attribute\Category\ExpressCategory;
use Concrete\Core\Express\ObjectManager;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\Control;
use Concrete\Core\Entity\Express\Entry\Association;

defined('C5_EXECUTE') or die("Access Denied.");

class AttributeKeyControl implements PublisherInterface
{

    protected $entityManager;
    protected $app;

    public function __construct(Application $app, EntityManager $entityManager)
    {
        $this->app = $app;
        $this->entityManager = $entityManager;
    }

    /**
     * @param \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express\AttributeKeyControl $source
     * @param $destination
     *
     * @return mixed
     */
    public function getControl(Control $source)
    {
        $objectManager = new ObjectManager($this->app, $this->entityManager);
        $entity = $source->getFieldSet()->getForm()->getEntity();
        $publishedEntity = $objectManager->getObjectByID($entity->getID());
        $category = new ExpressCategory($publishedEntity, $this->app, $this->entityManager);
        $key = $category->getAttributeKeyByHandle($source->getAttributeKey());

        $control = new \Concrete\Core\Entity\Express\Control\AttributeKeyControl();
        $control->setAttributeKey($key);
        return $control;
    }
}
