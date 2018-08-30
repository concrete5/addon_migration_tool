<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\AttributeKey;

use PortlandLabs\Concrete5\MigrationTool\Batch\Formatter\AttributeKeyCategory\UserFormatter;
use PortlandLabs\Concrete5\MigrationTool\Publisher\AttributeKeyCategory\UserPublisher;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class UserAttributeKeyCategoryInstance extends AttributeKeyCategoryInstance
{
    /**
     * @ORM\Column(type="boolean")
     */
    protected $displayed_in_profile = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $editable_in_profile = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $required_in_profile = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $editable_in_registration = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $required_in_registration = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $displayed_in_member_list = false;

    public function getHandle()
    {
        return 'user';
    }

    public function getFormatter()
    {
        return new UserFormatter($this);
    }

    /**
     * @return mixed
     */
    public function getDisplayedInProfile()
    {
        return $this->displayed_in_profile;
    }

    /**
     * @param mixed $displayed_in_profile
     */
    public function setDisplayedInProfile($displayed_in_profile)
    {
        $this->displayed_in_profile = $displayed_in_profile;
    }

    /**
     * @return mixed
     */
    public function getEditableInProfile()
    {
        return $this->editable_in_profile;
    }

    /**
     * @param mixed $editable_in_profile
     */
    public function setEditableInProfile($editable_in_profile)
    {
        $this->editable_in_profile = $editable_in_profile;
    }

    /**
     * @return mixed
     */
    public function getRequiredInProfile()
    {
        return $this->required_in_profile;
    }

    /**
     * @param mixed $required_in_profile
     */
    public function setRequiredInProfile($required_in_profile)
    {
        $this->required_in_profile = $required_in_profile;
    }

    /**
     * @return mixed
     */
    public function getEditableInRegistration()
    {
        return $this->editable_in_registration;
    }

    /**
     * @param mixed $editable_in_registration
     */
    public function setEditableInRegistration($editable_in_registration)
    {
        $this->editable_in_registration = $editable_in_registration;
    }

    /**
     * @return mixed
     */
    public function getRequiredInRegistration()
    {
        return $this->required_in_registration;
    }

    /**
     * @param mixed $required_in_registration
     */
    public function setRequiredInRegistration($required_in_registration)
    {
        $this->required_in_registration = $required_in_registration;
    }

    /**
     * @return mixed
     */
    public function getDisplayedInMemberList()
    {
        return $this->displayed_in_member_list;
    }

    /**
     * @param mixed $displayed_in_member_list
     */
    public function setDisplayedInMemberList($displayed_in_member_list)
    {
        $this->displayed_in_member_list = $displayed_in_member_list;
    }

    public function getPublisher()
    {
        return new UserPublisher();
    }
}
