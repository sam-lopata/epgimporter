<?php

namespace EPGImporter\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ServiceLivetvProgram
 *
 * @ORM\Table(name="service_livetv_program", indexes={@ORM\Index(name="indx_ext_program_id", columns={"ext_program_id"}), @ORM\Index(name="fk_service_livetv_show_type_id", columns={"show_type_id"}), @ORM\Index(name="indx_long_title", columns={"long_title"})})
 * @ORM\Entity(repositoryClass="EPGImporter\Entity\Repository\ServiceLivetvProgramRepository")
 */
class ServiceLivetvProgram
{
    /**
     * @var int
     *
     * @ORM\Column(name="ext_program_id", type="bigint", nullable=true, options={"unsigned"=true,"comment"="Metadata provider program id"})
     */
    private $extProgramId;

    /**
     * @var string
     *
     * @ORM\Column(name="long_title", type="string", length=255, nullable=false, options={"comment"="Program long title"})
     */
    private $longTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="grid_title", type="string", length=15, nullable=true, options={"comment"="Program grid title"})
     */
    private $gridTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="original_title", type="string", length=255, nullable=true, options={"comment"="Program original title"})
     */
    private $originalTitle;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duration", type="integer", nullable=true, options={"unsigned"=true,"comment"="Program duration"})
     */
    private $duration;

    /**
     * @var string|null
     *
     * @ORM\Column(name="iso_2_lang", type="string", length=2, nullable=true, options={"comment"="Program language"})
     */
    private $iso2Lang;

    /**
     * @var string|null
     *
     * @ORM\Column(name="eidr_id", type="string", length=50, nullable=true, options={"comment"="Program Entertainment Identifier Registry"})
     */
    private $eidrId;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \EPGImporter\Entity\ServiceLivetvShowType
     *
     * @ORM\ManyToOne(targetEntity="EPGImporter\Entity\ServiceLivetvShowType", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="show_type_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $showType;


    /**
     * Set extProgramId.
     *
     * @param int|null $extProgramId
     *
     * @return ServiceLivetvProgram
     */
    public function setExtProgramId($extProgramId = null) : self
    {
        $this->extProgramId = $extProgramId;

        return $this;
    }

    /**
     * Get extProgramId.
     *
     * @return int
     */
    public function getExtProgramId()
    {
        return $this->extProgramId;
    }

    /**
     * Set longTitle.
     *
     * @param string $longTitle
     *
     * @return ServiceLivetvProgram
     */
    public function setLongTitle($longTitle) : self
    {
        $this->longTitle = $longTitle;

        return $this;
    }

    /**
     * Get longTitle.
     *
     * @return string
     */
    public function getLongTitle()
    {
        return $this->longTitle;
    }

    /**
     * Set gridTitle.
     *
     * @param string|null $gridTitle
     *
     * @return ServiceLivetvProgram
     */
    public function setGridTitle($gridTitle = null) : self
    {
        $this->gridTitle = $gridTitle;

        return $this;
    }

    /**
     * Get gridTitle.
     *
     * @return string|null
     */
    public function getGridTitle()
    {
        return $this->gridTitle;
    }

    /**
     * Set originalTitle.
     *
     * @param string|null $originalTitle
     *
     * @return ServiceLivetvProgram
     */
    public function setOriginalTitle($originalTitle = null) : self
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    /**
     * Get originalTitle.
     *
     * @return string|null
     */
    public function getOriginalTitle()
    {
        return $this->originalTitle;
    }

    /**
     * Set duration.
     *
     * @param int|null $duration
     *
     * @return ServiceLivetvProgram
     */
    public function setDuration($duration = null) : self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration.
     *
     * @return int|null
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set iso2Lang.
     *
     * @param string|null $iso2Lang
     *
     * @return ServiceLivetvProgram
     */
    public function setIso2Lang($iso2Lang = null) : self
    {
        $this->iso2Lang = $iso2Lang;

        return $this;
    }

    /**
     * Get iso2Lang.
     *
     * @return string|null
     */
    public function getIso2Lang()
    {
        return $this->iso2Lang;
    }

    /**
     * Set eidrId.
     *
     * @param string|null $eidrId
     *
     * @return ServiceLivetvProgram
     */
    public function setEidrId($eidrId = null) : self
    {
        $this->eidrId = $eidrId;

        return $this;
    }

    /**
     * Get eidrId.
     *
     * @return string|null
     */
    public function getEidrId()
    {
        return $this->eidrId;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ServiceLivetvProgram
     */
    public function setCreatedAt($createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return ServiceLivetvProgram
     */
    public function setUpdatedAt($updatedAt = null) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime|null $deletedAt
     *
     * @return ServiceLivetvProgram
     */
    public function setDeletedAt($deletedAt = null) : self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
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

    /**
     * Set showType.
     *
     * @param \EPGImporter\Entity\ServiceLivetvShowType|null $showType
     *
     * @return ServiceLivetvProgram
     */
    public function setShowType(\EPGImporter\Entity\ServiceLivetvShowType $showType = null) : self
    {
        $this->showType = $showType;

        return $this;
    }

    /**
     * Get showType.
     *
     * @return \EPGImporter\Entity\ServiceLivetvShowType|null
     */
    public function getShowType()
    {
        return $this->showType;
    }
}
