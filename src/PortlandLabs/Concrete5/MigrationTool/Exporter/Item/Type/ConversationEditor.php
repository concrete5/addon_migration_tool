<?php
namespace PortlandLabs\Concrete5\MigrationTool\Exporter\Item\Type;

use Concrete\Core\Conversation\Editor\Editor;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ExportItem;
use PortlandLabs\Concrete5\MigrationTool\Entity\Export\ObjectCollection;
use Symfony\Component\HttpFoundation\Request;

defined('C5_EXECUTE') or die("Access Denied.");

class ConversationEditor extends AbstractType
{
    public function getHeaders()
    {
        return array(t('Name'));
    }

    public function exportCollection(ObjectCollection $collection, \SimpleXMLElement $element)
    {
        $node = $element->addChild('conversationeditors');
        foreach ($collection->getItems() as $type) {
            $t = Editor::getByID($type->getItemIdentifier());
            if (is_object($t)) {
                $this->exporter->export($t, $node);
            }
        }
    }

    public function getResultColumns(ExportItem $exportItem)
    {
        $t = Editor::getByID($exportItem->getItemIdentifier());
        $return = array();
        if (is_object($t)) {
            $return[] = $t->getConversationEditorName();
        }

        return $return;
    }

    public function getItemsFromRequest($array)
    {
        $items = array();
        foreach ($array as $id) {
            $t = Editor::getByID($id);
            if (is_object($t)) {
                $type = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\ConversationEditor();
                $type->setItemId($t->getConversationEditorID());
                $items[] = $type;
            }
        }

        return $items;
    }

    public function getResults(Request $request)
    {
        $list = Editor::getList();
        $items = array();
        foreach ($list as $t) {
            $item = new \PortlandLabs\Concrete5\MigrationTool\Entity\Export\ConversationEditor();
            $item->setItemId($t->getConversationEditorID());
            $items[] = $item;
        }

        return $items;
    }

    public function getHandle()
    {
        return 'conversation_editor';
    }

    public function getPluralDisplayName()
    {
        return t('Conversation Editor');
    }
}
