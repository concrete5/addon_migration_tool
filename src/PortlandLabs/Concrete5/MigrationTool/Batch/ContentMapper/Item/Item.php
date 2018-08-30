<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\ContentMapper\Item;

defined('C5_EXECUTE') or die("Access Denied.");

class Item implements ItemInterface
{
    protected $identifier;
    protected $displayName;

    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setDisplayName($name)
    {
        $this->displayName = $name;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getDisplayName()
    {
        if ($this->displayName) {
            return $this->displayName;
        }

        return $this->getIdentifier();
    }
}
