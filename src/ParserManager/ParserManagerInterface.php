<?php // @codeCoverageIgnoreStart

namespace EPGImporter\ParserManager;

use EPGImporter\DataManager\DataManagerInterface;
use EPGImporter\Generator\EntityGeneratorInterface;
use EPGImporter\Parser\ParserInterface;

/**
 * Interface ParserManagerInterface
 *
 * @package EPGImporter\ParserManager
 */
interface ParserManagerInterface
{
    /**
     * ParserManagerInterface constructor.
     *
     * @param ParserInterface          $parser  Parser object to use
     * @param DataManagerInterface     $dm      Data manager to get/update/persist data
     * @param EntityGeneratorInterface $eg      Generator to convert parsed data to object used by $dm
     * @param string                   $source  Name of the file to get data from
     */
    public function __construct(ParserInterface $parser, DataManagerInterface $dm, EntityGeneratorInterface $eg, string $source);

    /**
     * @return mixed
     */
    public function process();
}
