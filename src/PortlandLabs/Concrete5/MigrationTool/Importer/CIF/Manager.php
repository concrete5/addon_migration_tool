<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF;

use Concrete\Core\Utility\Service\Text;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\AttributeSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\AttributeType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\AttributeKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\AttributeKeyCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\BannedWord;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\BlockType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\BlockTypeSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Captcha;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ConfigValue;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ContentEditorSnippet;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ConversationEditor;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ConversationFlagType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ConversationRatingType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ExpressEntry;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ExpressEntity;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Group;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\User;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Job;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\JobSet;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Package;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Page;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PageFeed;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PageTemplate;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PageType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PageTypeComposerControlType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PageTypePublishTargetType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PermissionAccessEntityType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PermissionKey;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\PermissionKeyCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\SinglePage;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Site;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\SocialLink;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Stack;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Theme;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\ThumbnailType;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\Tree;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\WorkflowProgressCategory;
use PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Element\WorkflowType;

class Manager
{
    protected $routines = array();
    protected $additionalRoutines = array();
    protected $sortedRoutines;

    public function __construct()
    {
        $this->registerRoutine(new Group());
        $this->registerRoutine(new ThumbnailType());
        $this->registerRoutine(new BannedWord());
        $this->registerRoutine(new ExpressEntity());
        $this->registerRoutine(new SocialLink());
        $this->registerRoutine(new PermissionKeyCategory());
        $this->registerRoutine(new PermissionAccessEntityType());
        $this->registerRoutine(new PermissionKey());
        $this->registerRoutine(new Captcha());
        $this->registerRoutine(new Theme());
        $this->registerRoutine(new WorkflowType());
        $this->registerRoutine(new WorkflowProgressCategory());
        $this->registerRoutine(new PagetypePublishTargetType());
        $this->registerRoutine(new PageTypeComposerControlType());
        $this->registerRoutine(new AttributeType());
        $this->registerRoutine(new AttributeKeyCategory());
        $this->registerRoutine(new ConversationEditor());
        $this->registerRoutine(new ConversationFlagType());
        $this->registerRoutine(new ConversationRatingType());
        $this->registerRoutine(new AttributeKey());
        $this->registerRoutine(new AttributeSet());
        $this->registerRoutine(new User());
        $this->registerRoutine(new Job());
        $this->registerRoutine(new JobSet());
        $this->registerRoutine(new BlockType());
        $this->registerRoutine(new BlockTypeSet());
        $this->registerRoutine(new Stack());
        $this->registerRoutine(new SinglePage());
        $this->registerRoutine(new Site());
        $this->registerRoutine(new PageType());
        $this->registerRoutine(new Page());
        $this->registerRoutine(new PageTemplate());
        $this->registerRoutine(new PageFeed());
        $this->registerRoutine(new Package());
        $this->registerRoutine(new Tree());
        $this->registerRoutine(new ExpressEntry());
        $this->registerRoutine(new ConfigValue());
        $this->registerRoutine(new ContentEditorSnippet());
    }


    public function registerRoutine(ElementParserInterface $routine)
    {
        $this->routines[] = $routine;
    }

    public function replaceRoutine(ElementParserInterface $new, ElementParserInterface $replaced)
    {
        foreach($this->routines as $key => $value) {
            if (get_class($replaced) == get_class($value)) {
                $this->routines[$key] = $new;
            }
        }
    }

    protected function getHandle(ElementParserInterface $routine)
    {
        $class = substr(get_class($routine), strrpos(get_class($routine), '\\') + 1);
        $service = new Text();
        $handle = $service->handle($class);
        return $handle;
    }

    public function addRoutine(ElementParserInterface $routine, $addAfter)
    {
        $this->additionalRoutines[$addAfter] = $routine;
    }

    public function getRoutines()
    {
        if (!isset($this->sortedRoutines)) {
            $sortedRoutines = $this->routines;
            $replacements = array();
            foreach($this->additionalRoutines as $addAfter => $routine) {
                foreach($sortedRoutines as $i => $sortedRoutine) {
                    $handle = $this->getHandle($sortedRoutine);
                    if ($handle == $addAfter) {
                        $replacements[] = array($i, $routine);
                    }
                }
            }

            // This code sucks, but I'm not sure why it wasn't working in the more elegant way.

            foreach($replacements as $replacement) {
                $position = $replacement[0];
                $routine = $replacement[1];
                array_splice($sortedRoutines, $position + 1, 0, [$routine]);
            }

            $this->sortedRoutines = $sortedRoutines;
        }
        return $this->sortedRoutines;
    }

}
