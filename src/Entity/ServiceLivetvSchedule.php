<?php

namespace EPGImporter\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ServiceLivetvSchedule
 *
 * @ORM\Table(name="service_livetv_schedule", uniqueConstraints={@ORM\UniqueConstraint(name="index_channel_schedule", columns={"channel_id", "start_time", "end_time"}), @ORM\UniqueConstraint(name="index_ext_schedule_id", columns={"ext_schedule_id", "channel_id"})}, indexes={@ORM\Index(name="channel_id", columns={"channel_id"}), @ORM\Index(name="program_id", columns={"program_id"})})
 * @ORM\Entity(repositoryClass="EPGImporter\Entity\Repository\ServiceLivetvScheduleRepository")
 */
class ServiceLivetvSchedule
{
    /**
     * @var int
     *
     * @ORM\Column(name="ext_schedule_id", type="bigint", nullable=false, options={"unsigned"=true,"comment"="Metadata provider schedule id"})
     */
    private $extScheduleId;

    /**
     * @var int
     *
     * @ORM\Column(name="start_time", type="integer", length=11, nullable=false, options={"unsigned"=true,"comment"="Schedule start time"})
     */
    private $startTime;

    /**
     * @var int
     *
     * @ORM\Column(name="end_time", type="integer", length=11, nullable=false, options={"unsigned"=true,"comment"="Schedule end time"})
     */
    private $endTime;

    /**
     * @var int|null
     *
     * @ORM\Column(name="run_time", type="integer", length=11, nullable=true, options={"unsigned"=true,"comment"="Schedule duration/run time"})
     */
    private $runTime;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_live", type="boolean", nullable=true, options={"comment"="Is schedule a live broadcast"})
     */
    private $isLive;

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
     * @ORM\Column(name="id", type="integer", length=11,)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \EPGImporter\Entity\ServiceLivetvProgram
     *
     * @ORM\ManyToOne(targetEntity="EPGImporter\Entity\ServiceLivetvProgram", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="program_id", referencedColumnName="id")
     * })
     */
    private $program;

    /**
     * @var \EPGImporter\Entity\ServiceLivetvChannel
     *
     * @ORM\ManyToOne(targetEntity="EPGImporter\Entity\ServiceLivetvChannel", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable = false)
     * })
     */
    private $channel;


    /**
     * Set extScheduleId.
     *
     * @param int $extScheduleId
     *
     * @return ServiceLivetvSchedule
     */
    public function setExtScheduleId($extScheduleId) : self
    {
        $this->extScheduleId = $extScheduleId;

        return $this;
    }

    /**
     * Get extScheduleId.
     *
     * @return int
     */
    public function getExtScheduleId()
    {
        return $this->extScheduleId;
    }

    /**
     * Set startTime.
     *
     * @param int $startTime
     *
     * @return ServiceLivetvSchedule
     */
    public function setStartTime($startTime) : self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime.
     *
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime.
     *
     * @param int $endTime
     *
     * @return ServiceLivetvSchedule
     */
    public function setEndTime($endTime) : self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime.
     *
     * @return int
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set runTime.
     *
     * @param int|null $runTime
     *
     * @return ServiceLivetvSchedule
     */
    public function setRunTime($runTime = null) : self
    {
        $this->runTime = $runTime;

        return $this;
    }

    /**
     * Get runTime.
     *
     * @return int|null
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * Set isLive.
     *
     * @param bool|null $isLive
     *
     * @return ServiceLivetvSchedule
     */
    public function setIsLive($isLive = null) : self
    {
        $this->isLive = $isLive;

        return $this;
    }

    /**
     * Get isLive.
     *
     * @return bool|null
     */
    public function getIsLive()
    {
        return $this->isLive;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ServiceLivetvSchedule
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
     * @return ServiceLivetvSchedule
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
     * @return ServiceLivetvSchedule
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
     * Set program.
     *
     * @param \EPGImporter\Entity\ServiceLivetvProgram|null $program
     *
     * @return ServiceLivetvSchedule
     */
    public function setProgram(\EPGImporter\Entity\ServiceLivetvProgram $program = null) : self
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program.
     *
     * @return \EPGImporter\Entity\ServiceLivetvProgram|null
     */
    public function getProgram() : ?ServiceLivetvProgram
    {
        return $this->program;
    }

    /**
     * Set channel.
     *
     * @param \EPGImporter\Entity\ServiceLivetvChannel|null $channel
     *
     * @return ServiceLivetvSchedule
     */
    public function setChannel(\EPGImporter\Entity\ServiceLivetvChannel $channel = null) : self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Get channel.
     *
     * @return \EPGImporter\Entity\ServiceLivetvChannel|null
     */
    public function getChannel()
    {
        return $this->channel;
    }
}
