<?php // @codeCoverageIgnoreStart

namespace EPGImporter\Generator;

use EPGImporter\Entity\ServiceLivetvChannel;
use EPGImporter\Entity\ServiceLivetvSchedule;
use EPGImporter\Entity\ServiceLivetvShowType;

/**
 * Interface EntityGeneratorInterface
 *
 * @package Generator\EntityGeneratorInterface
 */
interface EntityGeneratorInterface
{
    /**
     * EntityGeneratorInterface constructor.
     *
     * @param string|null $entitySchema
     */
    public function __construct(string $entitySchema = null);

    /**
     * Generates Entities from provided node
     *
     * @param mixed     $eventNode
     * @param ServiceLivetvChannel  $channel
     * @param ServiceLivetvShowType $showType
     *
     * @return ServiceLivetvSchedule|null
     */
    public function createEntities($eventNode, ServiceLivetvChannel $channel, ServiceLivetvShowType $showType) : ?ServiceLivetvSchedule;
}
