<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\Express;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\ExpressEntity\Control\TextFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\ExpressEntity\Control\TextControl as TextControlPublisher;
/**
 * @ORM\Entity
 */
class TextControl extends Control
{

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $headline;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    /**
     * @return mixed
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * @param mixed $headline
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getFormatter()
    {
        return new TextFormatter($this);
    }

    public function getControlPublisher()
    {
        return new TextControlPublisher();
    }
}
