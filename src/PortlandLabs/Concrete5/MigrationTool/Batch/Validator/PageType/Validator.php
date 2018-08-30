<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator\PageType;

use Concrete\Core\Backup\ContentImporter\ValueInspector\Item\PageTemplateItem;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\AbstractValidator;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\MessageCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Page\Content\PageTemplateItemValidator;

defined('C5_EXECUTE') or die("Access Denied.");

class Validator extends AbstractValidator
{
    /**
     * @param $type \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType
     *
     * @return MessageCollection
     */
    public function validate($type)
    {
        $collection = new MessageCollection();

        // Validate the composer form controls
        foreach ($type->getLayoutSets() as $set) {
            foreach ($set->getControls() as $control) {
                $validator = $control->getRecordValidator($this->getBatch());
                if (is_object($validator)) {
                    $messages = $validator->validate($control);
                    $collection->addMessages($messages);
                }
            }
        }

        // Validate the page publish targets
        $target = $type->getPublishTarget();
        $validator = $target->getRecordValidator($this->getBatch());
        $messages = $validator->validate($target);
        $collection->addMessages($messages);

        // Validate the page templates
        $templates = array();
        if ($template = $type->getDefaultTemplate()) {
            $templates[] = $template;
        }
        if ($type->getAllowedTemplates() == 'C') {
            foreach ($type->getTemplates() as $template) {
                if (!in_array($template, $templates)) {
                    $templates[] = $template;
                }
            }
        }

        $validator = new PageTemplateItemValidator();
        foreach ($templates as $template) {
            $item = new PageTemplateItem($template);
            if (!$validator->itemExists($item, $this->getBatch())) {
                $validator->addMissingItemMessage($item, $collection);
            }
        }

        // Validate the page type defaults
        $defaultPages = $type->getDefaultPageCollection();
        $pageValidator = $defaultPages->getRecordValidator($this->getBatch());
        foreach ($defaultPages->getPages() as $page) {
            $pageMessages = $pageValidator->validate($page);
            if (is_object($pageMessages)) {
                $collection->addMessages($pageMessages);
            }
        }

        return $collection;
    }
}
