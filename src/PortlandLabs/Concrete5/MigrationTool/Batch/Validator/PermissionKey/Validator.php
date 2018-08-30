<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PermissionKey;

use Concrete\Core\Permission\Category;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Message;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{
    public function validate($key)
    {
        $messages = new MessageCollection();
        // Validate the category
        if (!$this->categoryExists($key->getCategory(), $this->getBatch())) {
            $messages->add(
                new Message(t('Permission category %s does not exist in the site or in the current content batch', $key->getCategory()))
            );
        }
        foreach ($key->getAccessEntities() as $entity) {
            $validator = $entity->getRecordValidator($this->getBatch());
            $entityMessages = $validator->validate($entity);
            if (is_object($entityMessages) && count($entityMessages)) {
                foreach ($entityMessages as $message) {
                    $messages->add($message);
                }
            }
        }

        return $messages;
    }

    public function categoryExists($handle, $batch)
    {
        $category = Category::getByHandle($handle);
        if (is_object($category)) {
            return true;
        }

        $categories = $batch->getObjectCollection('permission_key_category');
        foreach ($categories->getCategories() as $c) {
            if ($c->getHandle() == $handle) {
                return true;
            }
        }
    }
}
