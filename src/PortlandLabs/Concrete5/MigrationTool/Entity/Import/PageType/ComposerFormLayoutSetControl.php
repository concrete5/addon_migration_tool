<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import\PageType;

use PortlandLabs\Concrete5\MigrationTool\Batch\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\Table(name="MigrationImportPageTypeComposerFormLayoutSetControls")
 */
abstract class ComposerFormLayoutSetControl
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $position = 0;

    /**
     * @ORM\ManyToOne(targetEntity="ComposerFormLayoutSet")
     **/
    protected $set;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $custom_label;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_required = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $custom_template;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $output_control_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $item_identifier;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getComposerFormLayoutSet()
    {
        return $this->set;
    }

    /**
     * @param mixed $set
     */
    public function setComposerFormLayoutSet($set)
    {
        $this->set = $set;
    }

    /**
     * @return mixed
     */
    public function getCustomLabel()
    {
        return $this->custom_label;
    }

    /**
     * @param mixed $custom_label
     */
    public function setCustomLabel($custom_label)
    {
        $this->custom_label = $custom_label;
    }

    /**
     * @return mixed
     */
    public function getItemIdentifier()
    {
        return $this->item_identifier;
    }

    /**
     * @param mixed $item_identifier
     */
    public function setItemIdentifier($item_identifier)
    {
        $this->item_identifier = $item_identifier;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }

    /**
     * @param mixed $is_required
     */
    public function setIsRequired($is_required)
    {
        $this->is_required = $is_required;
    }

    /**
     * @return mixed
     */
    public function getCustomTemplate()
    {
        return $this->custom_template;
    }

    /**
     * @param mixed $custom_template
     */
    public function setCustomTemplate($custom_template)
    {
        $this->custom_template = $custom_template;
    }

    /**
     * @return mixed
     */
    public function getOutputControlId()
    {
        return $this->output_control_id;
    }

    /**
     * @param mixed $output_control_id
     */
    public function setOutputControlId($output_control_id)
    {
        $this->output_control_id = $output_control_id;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    abstract public function getHandle();

    public function getLabel()
    {
        if ($this->getCustomLabel()) {
            return $this->getCustomLabel();
        } else {
            return $this->getItemIdentifier();
        }
    }

    abstract public function getRecordValidator(ValidatorInterface $batch);
}
