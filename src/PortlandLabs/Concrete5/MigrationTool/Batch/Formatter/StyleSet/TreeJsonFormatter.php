<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\StyleSet;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\TreeContentItemFormatterInterface;
use PortlandLabs\Concrete5\MigrationTool\Entity\Import\StyleSet;

defined('C5_EXECUTE') or die("Access Denied.");

class TreeJsonFormatter implements TreeContentItemFormatterInterface
{
    protected $styleSet;

    public function __construct(StyleSet $styleSet)
    {
        $this->styleSet = $styleSet;
    }

    public function getBatchTreeNodeJsonObject()
    {
        $styleSetHolderNode = new \stdClass();
        $styleSetHolderNode->icon = 'fa fa-paint-brush';
        $styleSetHolderNode->title = t('Style Set');
        $styleSetHolderNode->children = array();

        $class = new \ReflectionClass($this->styleSet);
        foreach ($class->getMethods() as $methodObject) {
            $method = $methodObject->getName();
            if (strpos($method, 'get') === 0) {
                $property = substr($method, 3);
                $row = new \stdClass();
                $row->title = $property;
                $row->itemvalue = call_user_func(array(
                    $this->styleSet, $method, ));
                $styleSetHolderNode->children[] = $row;
            }
        }

        return $styleSetHolderNode;
    }
}
