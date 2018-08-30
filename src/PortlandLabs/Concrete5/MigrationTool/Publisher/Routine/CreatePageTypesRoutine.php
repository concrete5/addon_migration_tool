<?php
namespace PortlandLabs\Concrete5\MigrationTool\Publisher\Routine;

use Concrete\Core\Page\Template;
use PortlandLabs\Concrete5\MigrationTool\Batch\BatchInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\LoggerInterface;

defined('C5_EXECUTE') or die("Access Denied.");

class CreatePageTypesRoutine extends AbstractRoutine
{
    public function execute(BatchInterface $batch, LoggerInterface $logger)
    {
        $types = $batch->getObjectCollection('page_type');
        /*
         * @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\PageType
         */

        if (!$types) {
            return;
        }

        foreach ($types->getTypes() as $type) {
            if (!$type->getPublisherValidator()->skipItem()) {
                $logger->logPublishStarted($type);
                $pkg = null;
                if ($type->getPackage()) {
                    $pkg = \Package::getByHandle($type->getPackage());
                }
                $defaultTemplate = Template::getByHandle($type->getDefaultTemplate());
                $templates = array();
                if ($type->getAllowedTemplates() == 'C' || $type->getAllowedTemplates() == 'X') {
                    foreach ($type->getTemplates() as $templateHandle) {
                        $templates[] = Template::getByHandle($templateHandle);
                    }
                }
                $data = array(
                    'handle' => $type->getHandle(),
                    'name' => $type->getName(),
                    'defaultTemplate' => $defaultTemplate,
                    'allowedtempates' => $type->getAllowedTemplates(),
                    'internal' => $type->getIsInternal(),
                    'ptLaunchInComposer' => $type->getLaunchInComposer(),
                    'ptIsFrequentlyAdded' => $type->getIsFrequentlyAdded(),
                    'templates' => $templates,
                );

                $pageType = \Concrete\Core\Page\Type\Type::add($data, $pkg);

                foreach ($type->getLayoutSets() as $set) {
                    $layoutSet = $pageType->addPageTypeComposerFormLayoutSet($set->getName(),
                        $set->getDescription()
                    );

                    /*
                     * @var \PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType\ComposerFormLayoutSetControl
                     */
                    foreach ($set->getControls() as $controlEntity) {
                        $controlType = \Concrete\Core\Page\Type\Composer\Control\Type\Type::getByHandle($controlEntity->getHandle());
                        $control = $controlType->configureFromImportHandle($controlEntity->getItemIdentifier());
                        $setControl = $control->addToPageTypeComposerFormLayoutSet($layoutSet, true);
                        $setControl->updateFormLayoutSetControlRequired($controlEntity->getIsRequired());
                        $setControl->updateFormLayoutSetControlCustomTemplate($controlEntity->getCustomTemplate());
                        $setControl->updateFormLayoutSetControlCustomLabel($controlEntity->getCustomLabel());
                        $setControl->updateFormLayoutSetControlDescription($controlEntity->getDescription());
                    }
                }
                $logger->logPublishComplete($type, $pageType);
            } else {
                $logger->logSkipped($type);
            }
        }
    }
}
