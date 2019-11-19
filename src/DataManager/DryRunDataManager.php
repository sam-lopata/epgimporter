<?php // @codeCoverageIgnoreStart

namespace EPGImporter\DataManager;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineDataManager
 *
 * Provides callback methods needed for interaction with DB
 *
 * @package EPGImporter
 */
class DryRunDataManager implements DataManagerInterface
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
        return static function ($entities) {
            foreach ($entities as $entity) {
                if (null !== $entity) {
                    echo "Channel: ".$entity->getChannel()->getSourceId().
                        '; ExtScheduleId: '.$entity->getExtScheduleId()." Program: ".$entity->getProgram(
                        )->getLongTitle().
                        PHP_EOL;
                }
            }
        };
    }

    /**
     * @inheritDoc
     */

    public function getChannelCallback() : callable
    {
        return function($channelId) {
            return $this->em->getRepository("EPGImporter\Entity\ServiceLivetvChannel")->findOneBySourceId($channelId);
        };
    }

    /**
     * @inheritDoc
     */

    public function getShowTypeCallback() : callable
    {
        return function($type) {
            return $this->em->getRepository("EPGImporter\Entity\ServiceLivetvShowType")->findOneByType($type);
        };
    }
}
