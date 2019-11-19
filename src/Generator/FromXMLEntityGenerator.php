<?php

namespace EPGImporter\Generator;

use EPGImporter\Entity\ServiceLivetvChannel;
use EPGImporter\Entity\ServiceLivetvProgram;
use EPGImporter\Entity\ServiceLivetvSchedule;
use EPGImporter\Entity\ServiceLivetvShowType;

/**
 * Class FromXMLEntityGenerator
 *
 * @package EPGImporter\Generator\FromXMLEntityGenerator
 */
class FromXMLEntityGenerator implements EntityGeneratorInterface
{
    private static $entitySchema;

    /**
     * FromXMLEntityGenerator constructor.
     *
     * @param string|null $entitySchema Path to file with XSD schema for validation
     */
    public function __construct(string $entitySchema = null)
    {
        if (null === $entitySchema) {
            throw new \InvalidArgumentException('You must provide valid path to entity validation schema file');
        }

        if (!is_file($entitySchema))
            throw new \InvalidArgumentException( 'XSD schema file defined in \'xsd_schema\' parameter does not exist');{
        }

        self::$entitySchema = file_get_contents($entitySchema);

        if ("" === self::$entitySchema) {
            throw new \InvalidArgumentException('You should provide valid validation schema');
        }
    }

    /**
     * Extracts one <event> node data from provided SimpleXMLElement and converts it into entity
     *
     * @param \SimpleXMLElement     $eventNode
     * @param ServiceLivetvChannel  $channel
     * @param ServiceLivetvShowType $showType
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return ServiceLivetvSchedule|null
     */
    public function createEntities($eventNode, ServiceLivetvChannel $channel, ServiceLivetvShowType $showType) : ?ServiceLivetvSchedule
    {
        if (!($eventNode instanceof \SimpleXMLElement)) {
            throw new \InvalidArgumentException(sprintf(
                'Parameter $eventNode should be instance of \'\SimpleXMLElement\', \'%s\' given.',
                get_class($eventNode)
            ));
        }

        $this->validateSchema($eventNode);

        $extScheduleId = (int)$eventNode['id'];
        $programNode = $eventNode->language->short_event;
        $startTime = \DateTime::createFromFormat("d/m/y H:i:s", (string)$eventNode['start_time'], new \DateTimeZone('UTC'));
        if (false === $startTime) {
            throw new \RuntimeException(sprintf(
                'XML parse error. Wrong "start_time" format \'%s\'',
                $eventNode['start_time']
            ));
        }

        try {
            $duration = new \DateTime('@0 '.$eventNode['duration'], new \DateTimeZone('UTC'));
        }
        catch (\Exception $e){
            throw new \RuntimeException(sprintf(
                'XML parse error. Wrong "duration" format \'%s\'',
                $eventNode['duration']
            ));
        }

        $program = new ServiceLivetvProgram();
        $program->setExtProgramId($programNode['id'] ?? null)
            ->setLongTitle((string)$programNode['name'])
            ->setShowType($showType);

        $schedule = new ServiceLivetvSchedule();
        $schedule->setChannel($channel)
            ->setProgram($program)
            ->setExtScheduleId((int)$extScheduleId)
            ->setStartTime($startTime->getTimestamp())
            ->setRunTime($duration->getTimestamp())
            ->setEndTime($startTime->getTimestamp() + $duration->getTimestamp());

        return $schedule;
    }

    /**
     * Validate node XML against schema
     *
     * @param \SimpleXMLElement $eventNode
     * @throws \RuntimeException
     */
    private function validateSchema(\SimpleXMLElement $eventNode) : void
    {
        $internal_errors = libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadXML($eventNode->asXML());
        if (!$dom->schemaValidateSource(self::$entitySchema)) {
            $errors = libxml_get_errors();
            $message = "Invalid XML provided.\n";
            foreach ($errors as $error) {
                $message .= sprintf('XML error "%s" [%d] (Code %d) in %s on line %d column %d' . "\n",
                    $error->message, $error->level, $error->code, $error->file,
                    $error->line, $error->column);
            }
            throw new \RuntimeException($message);
        }
        libxml_use_internal_errors($internal_errors);
    }
}
