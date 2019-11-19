<?php

namespace EPGImporter\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ServiceLivetvChannel
 *
 *
 * @ORM\Table(name="service_livetv_channel", uniqueConstraints={@ORM\UniqueConstraint(name="short_name", columns={"short_name"}), @ORM\UniqueConstraint(name="uuid_unique", columns={"uuid"})})
 * @ORM\Entity(repositoryClass="EPGImporter\Entity\Repository\ServiceLivetvChannelRepository")
 */
class ServiceLivetvChannel
{
    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=36, nullable=false, options={"comment"="UUID identifier"})
     */
    private $uuid;

    /**
     * @var int
     *
     * @ORM\Column(name="source_id", type="integer", nullable=false, options={"comment"="Metadata provider id"})
     */
    private $sourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=30, nullable=false, options={"comment"="Short name for the channel"})
     */
    private $shortName;

    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=128, nullable=false, options={"comment"="Full name for the channel"})
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="time_zone", type="string", length=30, nullable=false)
     */
    private $timeZone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="primary_language", type="string", length=2, nullable=true, options={"comment"="Two character description for the channel"})
     */
    private $primaryLanguage;

    /**
     * @var int|null
     *
     * @ORM\Column(name="weight", type="integer", nullable=true, options={"comment"="Listing weight for the channel"})
     */
    private $weight;

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
     * Set uuid.
     *
     * @param string $uuid
     *
     * @return ServiceLivetvChannel
     */
    public function setUuid($uuid) : self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set sourceId.
     *
     * @param int $sourceId
     *
     * @return ServiceLivetvChannel
     */
    public function setSourceId($sourceId) : self
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId.
     *
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set shortName.
     *
     * @param string $shortName
     *
     * @return ServiceLivetvChannel
     */
    public function setShortName($shortName) : self
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName.
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set fullName.
     *
     * @param string $fullName
     *
     * @return ServiceLivetvChannel
     */
    public function setFullName($fullName) : self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName.
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set timeZone.
     *
     * @param string $timeZone
     *
     * @return ServiceLivetvChannel
     */
    public function setTimeZone($timeZone) : self
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone.
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Set primaryLanguage.
     *
     * @param string|null $primaryLanguage
     *
     * @return ServiceLivetvChannel
     */
    public function setPrimaryLanguage($primaryLanguage = null) : self
    {
        $this->primaryLanguage = $primaryLanguage;

        return $this;
    }

    /**
     * Get primaryLanguage.
     *
     * @return string|null
     */
    public function getPrimaryLanguage()
    {
        return $this->primaryLanguage;
    }

    /**
     * Set weight.
     *
     * @param int|null $weight
     *
     * @return ServiceLivetvChannel
     */
    public function setWeight($weight = null) : self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return int|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ServiceLivetvChannel
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
     * @return ServiceLivetvChannel
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
     * @return ServiceLivetvChannel
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
}
