<?php
namespace PortlandLabs\Concrete5\MigrationTool\Batch\Validator;

defined('C5_EXECUTE') or die("Access Denied.");

class Message implements \JsonSerializable, \Serializable
{
    const E_INFO = 1;
    const E_WARNING = 5;
    const E_DANGER = 10;
    const E_SUCCESS = 3;

    protected $severity;
    protected $text;

    public function __construct($text, $severity = self::E_DANGER)
    {
        $this->severity = $severity;
        $this->text = $text;
    }

    public function serialize()
    {
        return serialize([
            $this->severity,
            $this->text
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->severity,
            $this->text,
            ) = unserialize($serialized);
    }

    /**
     * @return mixed
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * @param mixed $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    public function getFormatter()
    {
        return new MessageFormatter($this);
    }

    public function __toString()
    {
        return (string) $this->text;
    }

    public function jsonSerialize()
    {
        $formatter = new MessageJsonFormatter($this);

        return $formatter->jsonSerialize();
    }


}
