<?php

namespace EPGImporter\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceLivetvShowType
 *
 * @ORM\Table(name="service_livetv_show_type")
 * @ORM\Entity(repositoryClass="EPGImporter\Entity\Repository\ServiceLivetvShowTypeRepository")
 */
class ServiceLivetvShowType
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=32, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Set type.
     *
     * @param string $type
     *
     * @return ServiceLivetvShowType
     */
    public function setType($type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
