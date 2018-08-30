<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Task;

use Concrete\Core\Foundation\Processor\ActionInterface;
use Concrete\Core\Foundation\Processor\TaskInterface;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\ValidatorTarget;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page;

defined('C5_EXECUTE') or die("Access Denied.");

class ValidatePagePathTask implements TaskInterface
{
    public function execute(ActionInterface $action)
    {
        /**
         * @var Page
         */
        $subject = $action->getSubject();
        /**
         * @var ValidatorTarget
         */
        $target = $action->getTarget();

        $path = $subject->getBatchPath();

        if ($path) {
            $container = substr($path, 0, strrpos($path, '/'));
            if ($container) {
                $em = \Database::connection()->getEntityManager();
                $r = $em->getRepository('\PortlandLabs\Concrete5\MigrationTool\Entity\Import\Page');
                $page = $r->findOneBy(array('batch_path' => $container));
                if (!is_object($page)) {
                    $action->getTarget()->addMessage(
                        new Message(t('Container path %s not found in import batch. A blank container page will be substituted.', $container), Message::E_WARNING)
                    );
                }
            }
        }
    }

    public function finish(ActionInterface $action)
    {
    }
}
