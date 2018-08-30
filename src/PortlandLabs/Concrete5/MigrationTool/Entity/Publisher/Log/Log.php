<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log;

use Doctrine\Common\Collections\ArrayCollection;
use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\Attribute\ValidatableAttributesInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\PublishableInterface;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\PageValidator;
use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Validator\SiteValidator;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogs")
 */
class Log
{
    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="guid")
     */
    protected $batch_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $batch_name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date_started;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="log", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     **/
    protected $entries;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="log", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     **/
    protected $messages;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\User\User")
     * @ORM\JoinColumn(name="uID", referencedColumnName="uID", onDelete="CASCADE")
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\Site\Site")
     * @ORM\JoinColumn(name="siteID", referencedColumnName="siteID", onDelete="CASCADE")
     **/
    protected $site;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date_completed;

    public function __construct()
    {
        $this->date_started = new \DateTime();
        $this->entries = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDateStarted()
    {
        return $this->date_started;
    }

    /**
     * @param mixed $date_started
     */
    public function setDateStarted($date_started)
    {
        $this->date_started = $date_started;
    }

    /**
     * @return mixed
     */
    public function getDateCompleted()
    {
        return $this->date_completed;
    }

    /**
     * @param mixed $date_completed
     */
    public function setDateCompleted($date_completed)
    {
        $this->date_completed = $date_completed;
    }

    /**
     * @return mixed
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @param mixed $entries
     */
    public function setEntries($entries)
    {
        $this->entries = $entries;
    }

    public function __sleep()
    {
        if ($this->id) {
            return array('id');
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return mixed
     */
    public function getBatchId()
    {
        return $this->batch_id;
    }

    /**
     * @param mixed $batch_id
     */
    public function setBatchId($batch_id)
    {
        $this->batch_id = $batch_id;
    }

    /**
     * @return mixed
     */
    public function getBatchName()
    {
        return $this->batch_name;
    }

    /**
     * @param mixed $batch_name
     */
    public function setBatchName($batch_name)
    {
        $this->batch_name = $batch_name;
    }







}
