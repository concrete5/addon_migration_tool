<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Publisher\Log\Object;

use Doctrine\ORM\Mapping as ORM;
use PortlandLabs\Concrete5\MigrationTool\Publisher\Logger\Formatter\Object\SocialLinksFormatter;

/**
 * @ORM\Entity
 * @ORM\Table(name="MigrationPublisherLogSocialLinkObjects")
 */
class SocialLink extends LoggableObject
{

    use \PortlandLabs\Concrete5\MigrationTool\Entity\Traits\SocialLink;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\Sharing\SocialNetwork\Link")
     * @ORM\JoinColumn(name="slID", referencedColumnName="slID", onDelete="CASCADE")
     **/
    protected $link;

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }


    public function getLogFormatter()
    {
        return new SocialLinksFormatter();
    }

}
