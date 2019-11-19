<?php

namespace EPGImporter\DataManager;

use Doctrine\ORM\EntityManagerInterface;
use EPGImporter\Entity\ServiceLivetvChannel;
use EPGImporter\Entity\ServiceLivetvSchedule;
use EPGImporter\Entity\ServiceLivetvShowType;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class DoctrineDataManager
 *
 * Provides callback methods needed for interaction with DB
 *
 * @package EPGImporter
 */
class DoctrineDataManager implements DataManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    private $counter = 0;

    /**
     * DoctrineDataManager constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * @inheritDoc
     */
    public function getPersistCallback() : callable
    {
        return function ($entities) {
                /** @var ServiceLivetvSchedule $entity */
                foreach ($entities as $entity) {
                    if (null !== $entity) {
                        $this->counter++;
                        $this->em->persist($entity);
                    }
                }
                $this->em->flush();
                $this->em->clear();
        };
    }

    /**
     * @inheritDoc
     */

    public function getChannelCallback() : callable
    {
        return function($channelId) {
            return $this->em->getRepository(ServiceLivetvChannel::class)->findOneBySourceId($channelId);
        };
    }

    /**
     * @inheritDoc
     */

    public function getShowTypeCallback() : callable
    {
        return function($type) {
            return $this->em->getRepository(ServiceLivetvShowType::class)->findOneByType($type);
        };
    }

}
