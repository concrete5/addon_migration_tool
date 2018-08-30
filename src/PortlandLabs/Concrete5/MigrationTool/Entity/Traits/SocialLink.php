<?php
namespace PortlandLabs\Concrete5\MigrationTool\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;

trait SocialLink
{

    /**
     * @ORM\Column(type="string")
     */
    protected $service;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;


    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

}
