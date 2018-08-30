<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AttributeKey;

use Concrete\Core\Tree\Tree;
use Concrete\Core\Tree\Type\Topic;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey\TopicsAttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class TopicsValidator extends AbstractValidator
{
    /**
     * @param $key TopicsAttributeKey
     *
     * @return MessageCollection
     */
    public function validate($key)
    {
        $messages = new MessageCollection();
        if (!$this->topicTreeExists($key->getTreeName(), $this->getBatch())) {
            $messages->add(
                new Message(t('Topic tree %s does not exist in the site or in the current content batch', $key->getTreeName()))
            );
        }

        return $messages;
    }

    public function topicTreeExists($name, $batch)
    {
        $tree = Topic::getByName($name);
        if (is_object($tree)) {
            return true;
        }

        $r = \Package::getByHandle('migration_tool')->getEntityManager()->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Tree');
        $tree = $r->findOneByName($name);
        if (is_object($tree)) {
            return true;
        }

        return false;
    }
}
